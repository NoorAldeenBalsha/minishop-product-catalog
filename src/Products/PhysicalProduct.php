<?php

declare(strict_types=1);

require_once __DIR__ . '/Product.php';

class PhysicalProduct extends Product
{
    public const SHIPPING_RATE_PER_GRAM = 0.01;
    private int $stockQuantity;
    private float $weightInGrams;

    public function __construct(
        string $id,
        string $name,
        float $price,
        string $category,
        DiscountInterface $discount,
        int $stockQuantity,
        float $weightInGrams,
        ?string $createdAt = null
    ) {
        parent::__construct($id, $name, $price, $category, $discount, $createdAt);
        $this->setStockQuantity($stockQuantity);
        $this->setWeightInGrams($weightInGrams);
    }

    public function setStockQuantity(int $stockQuantity): void {
        if ($stockQuantity < 0) {
            throw new InvalidArgumentException("Error: Stock quantity cannot be less than zero.");
        }
        $this->stockQuantity = $stockQuantity;
    }

    public function setWeightInGrams(float $weightInGrams): void {
        if ($weightInGrams <= 0) {
            throw new InvalidArgumentException("Error: Weight in grams must be greater than zero.");
        }
        $this->weightInGrams = round($weightInGrams, 2);
    }

    public function sellStock(int $quantity): void {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("Error: Quantity to sell must be greater than zero.");
        }

        if ($quantity > $this->stockQuantity) {
            throw new InvalidArgumentException(
                "Error: Cannot sell " . $quantity . " items. Only " . $this->stockQuantity . " available in stock."
            );
        }

        $this->stockQuantity -= $quantity;
    }

    public function getStockQuantity(): int {
        return $this->stockQuantity;
    }

    public function getWeightInGrams(): float {
        return $this->weightInGrams;
    }

    public function getType(): string {
        return 'physical';
    }

    public function calculateShippingCost(): float {
        return round($this->weightInGrams * self::SHIPPING_RATE_PER_GRAM, 2);
    }

    protected function getExtraDisplayInfo(): string {
        return "Stock Quantity:   " . $this->stockQuantity . " units" . PHP_EOL
            . "Weight:           " . $this->weightInGrams . "g";
    }

    public function toArray(): array {
        // array_merge: Merges the elements of one or more arrays together.
        return array_merge($this->getCommonArray(), [
            'stockQuantity' => $this->stockQuantity,
            'weightInGrams' => $this->weightInGrams,
        ]);
    }
}