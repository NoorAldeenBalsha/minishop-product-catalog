<?php

declare(strict_types=1);

require_once __DIR__ . '/DiscountInterface.php';

class FixedDiscount implements DiscountInterface
{
    private float $amount;

    // __construct: Magic Method Called Automatically Upon Object Creation With New.
    public function __construct(float $amount)
    {
        $this->setAmount($amount);
    }

    private function setAmount(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Error: Fixed discount amount must be greater than zero.");
            // This Function Is From https://www.php.net/manual/en/class.invalidargumentexception.php
        }

        $this->amount = $amount;
    }

    public function __invoke(float $originalPrice): float
    {
        if ($originalPrice <= 0) {
            throw new InvalidArgumentException("Error: Product price must be greater than zero.");
        }

        if ($this->amount > $originalPrice) {
            throw new InvalidArgumentException(
                "Error: Fixed discount ($" . $this->amount . ") cannot exceed product price ($" . $originalPrice . ")."
            );
        }

        return round($originalPrice - $this->amount, 2);
    }

    public function getType(): string
    {
        return 'fixed';
    }

    public function getValue(): float
    {
        return $this->amount;
    }

    public function __toString(): string
    {
        return "$" . $this->amount . " OFF";
    }
}