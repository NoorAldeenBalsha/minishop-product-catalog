<?php

declare(strict_types=1);

require_once __DIR__ . '/DiscountInterface.php';

class PercentageDiscount implements DiscountInterface
{
    public const MIN_PERCENTAGE = 1.0;
    public const MAX_PERCENTAGE = 70.0;

    private float $percentage;

    // __construct: Magic Method Called Automatically Upon Object Creation With New.
    public function __construct(float $percentage)
    {
        $this->setPercentage($percentage);
    }

    private function setPercentage(float $percentage): void
    {
        if ($percentage < self::MIN_PERCENTAGE || $percentage > self::MAX_PERCENTAGE) {
            throw new InvalidArgumentException("Error: Percentage discount must be between 1% and 70%.");
        }

        $this->percentage = $percentage;
    }

    public function __invoke(float $originalPrice): float
    {
        if ($originalPrice <= 0) {
            throw new InvalidArgumentException("Error: Product price must be greater than zero.");
        }

        $discountValue = $originalPrice * ($this->percentage / 100);

        // round: Rounds A Float Number To A Specified Precision.
        return round($originalPrice - $discountValue, 2);
        // This Function Is From https://www.php.net/manual/en/function.round.php
    }

    public function getType(): string
    {
        return 'percentage';
    }

    public function getValue(): float
    {
        return $this->percentage;
    }

    public function __toString(): string
    {return $this->percentage . "% OFF";
    }
}