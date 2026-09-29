<?php

declare(strict_types=1);

require_once __DIR__ . '\..\Discounts\DiscountInterface.php';

abstract class Product
{
    private string $id;
    private string $name;
    private float $price;
    private string $category;
    private string $createdAt;
    private DiscountInterface $discount;

    public function __construct(
        string $id,
        string $name,
        float $price,
        string $category,
        DiscountInterface $discount,
        ?string $createdAt = null
    ) {
        $this->setId($id);
        $this->setName($name);
        $this->setCategory($category);
        $this->updatePricing($price, $discount);
        $this->createdAt = $createdAt ?? date('Y-m-d H:i:s');
    }

    private function setId(string $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setCategory(string $category): void {
        $cleanCategory = trim($category);
        if ($cleanCategory === '') {
            throw new InvalidArgumentException("Error: Product category cannot be empty.");
        }

        $this->category = $cleanCategory;
    }

    public function updatePricing(float $price, DiscountInterface $discount): void {
        if ($price <= 0) {
            throw new InvalidArgumentException("Error: Product price must be greater than zero.");
        }

        // Invoke the discount magic method to validate compatibility with the price.
        $discount($price);

        $this->price = round($price, 2);
        $this->discount = $discount;
    }

    public function setPrice(float $price): void {
        $this->updatePricing($price, $this->discount);
    }

    public function setDiscount(DiscountInterface $discount): void {
        $this->updatePricing($this->price, $discount);
    }

    public function getId(): string {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getPriceAfterDiscount(): float {
        $discountCalculator = $this->discount;
        return $discountCalculator($this->price);
    }

    public function getCategory(): string {
        return $this->category;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function getDiscount(): DiscountInterface {
        return $this->discount;
    }

    abstract public function getType(): string;

    abstract public function calculateShippingCost(): float;

    abstract protected function getExtraDisplayInfo(): string;

    abstract public function toArray(): array;

    protected function getCommonArray(): array {
        return [
            'id' => $this->id,
            'type' => $this->getType(),
            'name' => $this->name,
            'price' => $this->price,
            'category' => $this->category,
            'createdAt' => $this->createdAt,
            'discountType' => $this->discount->getType(),
            'discountValue' => $this->discount->getValue(),
        ];
    }

    public function __toString(): string {
        return "--------------------------------------------------" . PHP_EOL
            . "ID:               " . $this->id . PHP_EOL
            . "Type:             " . $this->getType() . PHP_EOL
            . "Name:             " . $this->name . PHP_EOL
            . "Category:         " . $this->category . PHP_EOL
            . "Original Price:   $" . $this->price . PHP_EOL
            . "Discount:         " . $this->discount . PHP_EOL
            . "Final Price:      $" . $this->getPriceAfterDiscount() . PHP_EOL
            . "Shipping Cost:    $" . $this->calculateShippingCost() . PHP_EOL
            . $this->getExtraDisplayInfo() . PHP_EOL
            . "Created At:       " . $this->createdAt . PHP_EOL
            . "--------------------------------------------------";
    }
}