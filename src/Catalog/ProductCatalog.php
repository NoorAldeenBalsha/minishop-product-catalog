<?php

declare(strict_types=1);

require_once __DIR__ . '\..\Traits\Logger.php';
require_once __DIR__ . '\..\Storage\StorageInterface.php';
require_once __DIR__ . '\..\Discounts\DiscountInterface.php';
require_once __DIR__ . '\..\Discounts\NoDiscount.php';
require_once __DIR__ . '\..\Discounts\PercentageDiscount.php';
require_once __DIR__ . '\..\Discounts\FixedDiscount.php';
require_once __DIR__ . '\..\Products\Product.php';
require_once __DIR__ . '\..\Products\PhysicalProduct.php';
require_once __DIR__ . '\..\Products\DigitalProduct.php';

class ProductCatalog
{
    use Logger;

    private StorageInterface $storage;
    private array $products = [];

    public function __construct(StorageInterface $storage) {
        $this->storage = $storage;
        $this->loadProductsFromStorage();
    }

    public function addProduct(Product $product): void {
        $id = $product->getId();

        // array_key_exists: Checks if the given key or index exists in the array.
        if (array_key_exists($id, $this->products)) {
            throw new InvalidArgumentException("Error: Product ID '" . $id . "' already exists. IDs must be unique.");
        }

        $this->products[$id] = $product;
        $this->saveProductsToStorage();
        $this->logOperation("ADD", "Added product ID: " . $id . " (" . $product->getName() . ")");
    }

    public function getAllProducts(): array {
        return $this->products;
    }

    public function getProductsCount(): int {
        return count($this->products);
    }

    public function findProductById(string $id): Product {
        $cleanId = trim($id);
        if (!array_key_exists($cleanId, $this->products)) {
            throw new InvalidArgumentException("Error: Product with ID '" . $cleanId . "' was not found.");
        }
        return $this->products[$cleanId];
    }

    public function updateProduct(
        string $id,
        string $newName,
        float $newPrice,
        string $newCategory,
        DiscountInterface $newDiscount,
        array $extraData = []
    ): void {
        $product = $this->findProductById($id);
        $product->setName($newName);
        $product->setCategory($newCategory);
        $product->updatePricing($newPrice, $newDiscount);

        if ($product instanceof PhysicalProduct) {
            if (array_key_exists('stockQuantity', $extraData)) {
                $product->setStockQuantity((int)$extraData['stockQuantity']);
            }
            if (array_key_exists('weightInGrams', $extraData)) {
                $product->setWeightInGrams((float)$extraData['weightInGrams']);
            }
        } elseif ($product instanceof DigitalProduct) {
            if (array_key_exists('downloadUrl', $extraData)) {
                $product->setDownloadUrl((string)$extraData['downloadUrl']);
            }
        }

        $this->saveProductsToStorage();
        $this->logOperation("UPDATE", "Updated product ID: " . $product->getId() . " (" . $product->getName() . ")");
    }

    public function deleteProduct(string $id): void {
        $product = $this->findProductById($id);
        $productId = $product->getId();
        $productName = $product->getName();

        unset($this->products[$productId]);
        $this->saveProductsToStorage();
        $this->logOperation("DELETE", "Deleted product ID: " . $productId . " (" . $productName . ")");
    }

    public function createDiscountFromInput(string $discountType, float $discountValue): DiscountInterface {
        $normalizedType = strtolower(trim($discountType));

        switch ($normalizedType) {
            case 'percentage':
                return new PercentageDiscount($discountValue);
            case 'fixed':
                return new FixedDiscount($discountValue);
            case 'none':
            default:
                return new NoDiscount();
        }
    }

    private function saveProductsToStorage(): void {
        $rawList = [];
        foreach ($this->products as $product) {
            $rawList[] = $product->toArray();
        }

        $this->storage->saveAll($rawList);
    }

    private function loadProductsFromStorage(): void {
        $rawItems = $this->storage->loadAll();

        foreach ($rawItems as $item) {
            if (!is_array($item)) {
                continue;
            }

            try {
                $product = $this->reconstructProduct($item);
                $this->products[$product->getId()] = $product;
            } catch (Exception $e) {
                // Ignore corrupted individual records so the application never crashes
                continue;
            }
        }
    }

    private function reconstructProduct(array $item): Product {
        $id = (string)($item['id'] ?? '');
        $type = strtolower((string)($item['type'] ?? ''));
        $name = (string)($item['name'] ?? '');
        $price = (float)($item['price'] ?? 0);
        $category = (string)($item['category'] ?? '');
        $createdAt = isset($item['createdAt']) ? (string)$item['createdAt'] : null;
        $discountType = (string)($item['discountType'] ?? 'none');
        $discountValue = (float)($item['discountValue'] ?? 0.0);

        $discount = $this->createDiscountFromInput($discountType, $discountValue);

        if ($type === 'physical') {
            $stockQuantity = (int)($item['stockQuantity'] ?? 0);
            $weightInGrams = (float)($item['weightInGrams'] ?? 0.0);

            return new PhysicalProduct(
                $id,
                $name,
                $price,
                $category,
                $discount,
                $stockQuantity,
                $weightInGrams,
                $createdAt
            );
        }

        if ($type === 'digital') {
            $downloadUrl = (string)($item['downloadUrl'] ?? '');

            return new DigitalProduct(
                $id,
                $name,
                $price,
                $category,
                $discount,
                $downloadUrl,
                $createdAt
            );
        }

        throw new InvalidArgumentException("Error: Unknown product type '" . $type . "'.");
    }
}