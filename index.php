<?php

declare(strict_types=1);

require_once __DIR__  . '/src/Storage/JsonStorage.php';
require_once __DIR__ . '/src/Catalog/ProductCatalog.php';

function readInput(string $prompt): string
{
    echo $prompt;

    // fgets: Reads a line of input from the standard input stream (terminal).
    // This Function From https://www.php.net/manual/en/function.fgets.php
    $line = fgets(STDIN);
    if ($line === false) {
        return '';
    }

    return trim($line);
}

function readFloatInput(string $prompt): float
{
    $input = readInput($prompt);

    // is_numeric: Checks whether a variable is a number or a numeric string.
    // This Function From https://www.php.net/manual/en/function.is-numeric.php
    if (!is_numeric($input)) {
        throw new InvalidArgumentException("Error: Expected a valid numeric value.");
    }

    return (float)$input;
}

function readIntInput(string $prompt): int
{
    $input = readInput($prompt);
    if (!is_numeric($input)) {
        throw new InvalidArgumentException("Error: Expected a valid integer value.");
    }

    return (int)$input;
}

function promptDiscount(ProductCatalog $catalog): DiscountInterface
{
    echo "Select Discount Type:" . PHP_EOL;
    echo "  1) No Discount" . PHP_EOL;
    echo "  2) Percentage Discount (1% - 70%)" . PHP_EOL;
    echo "  3) Fixed Amount Discount" . PHP_EOL;
    $choice = readInput("Enter choice (1-3): ");

    switch ($choice) {
        case '2':
            $percent = readFloatInput("Enter discount percentage (1 - 70): ");
            return $catalog->createDiscountFromInput('percentage', $percent);
        case '3':$amount = readFloatInput("Enter fixed discount amount ($): ");
            return $catalog->createDiscountFromInput('fixed', $amount);
        case '1':
        default:
            return $catalog->createDiscountFromInput('none', 0.0);
    }
}

$storageFile = __DIR__  . '/products.json';
$storage = new JsonStorage($storageFile);
$catalog = new ProductCatalog($storage);

$running = true;

while ($running) {
    echo PHP_EOL . "================ MINISHOP PRODUCT CATALOG ================" . PHP_EOL;
    echo "1. Add a new product" . PHP_EOL;
    echo "2. List all products (" . $catalog->getProductsCount() . " items)" . PHP_EOL;
    echo "3. Find a product by ID" . PHP_EOL;
    echo "4. Update an existing product" . PHP_EOL;
    echo "5. Delete a product" . PHP_EOL;
    echo "6. Sell stock from a physical product" . PHP_EOL;
    echo "0. Exit" . PHP_EOL;
    echo "==========================================================" . PHP_EOL;

    $option = readInput("Choose an operation (0-6): ");

    try {
        switch ($option) {
            case '1':
                echo PHP_EOL . "--- Add New Product ---" . PHP_EOL;
                $id = readInput("Product ID: ");
                $name = readInput("Product Name (min 3 chars): ");
                $category = readInput("Category: ");
                $price = readFloatInput("Price ($): ");
                $discount = promptDiscount($catalog);

                echo "Product Type:" . PHP_EOL;
                echo "  1) Physical Product" . PHP_EOL;
                echo "  2) Digital Product" . PHP_EOL;
                $typeChoice = readInput("Choose type (1 or 2): ");

                if ($typeChoice === '1') {
                    $stock = readIntInput("Stock Quantity: ");
                    $weight = readFloatInput("Weight in Grams (g): ");
                    $product = new PhysicalProduct($id, $name, $price, $category, $discount, $stock, $weight);
                    $catalog->addProduct($product);
                    echo "SUCCESS: Physical product added successfully!" . PHP_EOL;
                } elseif ($typeChoice === '2') {
                    $url = readInput("Download URL (e.g. https://example.com/file.zip): ");
                    $product = new DigitalProduct($id, $name, $price, $category, $discount, $url);
                    $catalog->addProduct($product);
                    echo "SUCCESS: Digital product added successfully!" . PHP_EOL;
                } else {
                    echo "Error: Invalid product type choice." . PHP_EOL;
                }
                break;

            case '2':
                echo PHP_EOL . "--- All Catalog Products ---" . PHP_EOL;
                $allProducts = $catalog->getAllProducts();
                if ($catalog->getProductsCount() === 0) {
                    echo "The catalog is currently empty." . PHP_EOL;
                } else {
                    foreach ($allProducts as $item) {
                        echo $item . PHP_EOL;
                    }
                }
                break;

            case '3':
                echo PHP_EOL . "--- Find Product by ID ---" . PHP_EOL;
                $searchId = readInput("Enter Product ID: ");
                $foundProduct = $catalog->findProductById($searchId);
                echo $foundProduct . PHP_EOL;
                break;

            case '4':
                echo PHP_EOL . "--- Update Product ---" . PHP_EOL;
                $updateId = readInput("Enter Product ID to update: ");
                $existing = $catalog->findProductById($updateId);
                echo "Current Product Details:" . PHP_EOL . $existing . PHP_EOL;

                $newName = readInput("New Name [" . $existing->getName() . "]: ");
                if ($newName === '') {
                    $newName = $existing->getName();
                }

                $newCategory = readInput("New Category [" . $existing->getCategory() . "]: ");
                if ($newCategory === '') {
                    $newCategory = $existing->getCategory();
                }$priceInput = readInput("New Price [$" . $existing->getPrice() . "]: ");
                $newPrice = ($priceInput === '') ? $existing->getPrice() : (float)$priceInput;

                $changeDiscount = strtolower(readInput("Change discount? (y/n): "));
                $newDiscount = ($changeDiscount === 'y') ? promptDiscount($catalog) : $existing->getDiscount();

                $extra = [];
                if ($existing instanceof PhysicalProduct) {
                    $stockInput = readInput("New Stock [" . $existing->getStockQuantity() . "]: ");
                    if ($stockInput !== '') {
                        $extra['stockQuantity'] = (int)$stockInput;
                    }

                    $weightInput = readInput("New Weight in grams [" . $existing->getWeightInGrams() . "]: ");
                    if ($weightInput !== '') {
                        $extra['weightInGrams'] = (float)$weightInput;
                    }
                } elseif ($existing instanceof DigitalProduct) {
                    $urlInput = readInput("New Download URL [" . $existing->getDownloadUrl() . "]: ");
                    if ($urlInput !== '') {
                        $extra['downloadUrl'] = $urlInput;
                    }
                }

                $catalog->updateProduct($updateId, $newName, $newPrice, $newCategory, $newDiscount, $extra);
                echo "SUCCESS: Product updated successfully!" . PHP_EOL;
                break;

            case '5':
                echo PHP_EOL . "--- Delete Product ---" . PHP_EOL;
                $deleteId = readInput("Enter Product ID to delete: ");
                $catalog->deleteProduct($deleteId);
                echo "SUCCESS: Product deleted successfully!" . PHP_EOL;
                break;

            case '6':
                echo PHP_EOL . "--- Sell Physical Product Stock ---" . PHP_EOL;
                $sellId = readInput("Enter Physical Product ID: ");
                $productToSell = $catalog->findProductById($sellId);
                if (!($productToSell instanceof PhysicalProduct)) {
                    echo "Notice: Digital products are always available and do not have stock limits." . PHP_EOL;
                } else {
                    $qty = readIntInput("Enter quantity to sell: ");
                    $productToSell->sellStock($qty);
                    $catalog->updateProduct(
                        $productToSell->getId(),
                        $productToSell->getName(),
                        $productToSell->getPrice(),
                        $productToSell->getCategory(),
                        $productToSell->getDiscount(),
                        ['stockQuantity' => $productToSell->getStockQuantity()]
                    );
                    echo "SUCCESS: Sold " . $qty . " units. Remaining stock: " . $productToSell->getStockQuantity() . PHP_EOL;
                }
                break;

            case '0':
                $running = false;
                echo "Goodbye! All data is saved in products.json." . PHP_EOL;
                break;

            default:
                echo "Invalid option. Please choose between 0 and 6." . PHP_EOL;
        }
    } catch (Exception $e) {
        echo PHP_EOL . "[VALIDATION ERROR] " . $e->getMessage() . PHP_EOL;
    }
}