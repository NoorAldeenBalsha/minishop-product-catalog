<?php

declare(strict_types=1);

interface DiscountInterface
{
    // __invoke: Magic Method Triggered When Calling An Object As A Function.
    public function __invoke(float $originalPrice): float;

    // getType: Returns The Type Of Discount To Save It in JSON File.
    public function getType(): string;

    // getValue: Returns The Value Of Discount To Save It in JSON File.
    public function getValue(): float;

    // __toString: Magic Method Triggered When Converting An Object To A String.
    public function __toString(): string;
}