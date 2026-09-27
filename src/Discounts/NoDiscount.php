<?php

declare(strict_types=1);

require_once __DIR__ . '/DiscountInterface.php';

class NoDiscount implements DiscountInterface
{
    public function __invoke(float $originalPrice): float
    {
        if ($originalPrice <= 0) {
            throw new InvalidArgumentException("Error: Product price must be greater than zero.");
        }

        return $originalPrice;
    }

    public function getType(): string
    {
        return 'none';
    }

    public function getValue(): float
    {
        return 0.0;
    }

    public function __toString(): string
    {
        return "No Discount";
    }
}