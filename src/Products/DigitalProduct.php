<?php

declare(strict_types=1);

require_once __DIR__ . '/Product.php';

class DigitalProduct extends Product
{
    private string $downloadUrl;

    public function __construct(
        string $id,
        string $name,
        float $price,
        string $category,
        DiscountInterface $discount,
        string $downloadUrl,
        ?string $createdAt = null
    ) {
        parent::__construct($id, $name, $price, $category, $discount, $createdAt);
        $this->setDownloadUrl($downloadUrl);
    }

    public function setDownloadUrl(string $downloadUrl): void
    {
        $cleanUrl = trim($downloadUrl);

        // filter_var: Filters a variable with a specified validation filter.
        if (filter_var($cleanUrl, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException("Error: Invalid download URL format.");
        }

        $this->downloadUrl = $cleanUrl;
    }

    public function getDownloadUrl(): string
    {
        return $this->downloadUrl;
    }

    public function getType(): string
    {
        return 'digital';
    }public function calculateShippingCost(): float
    {
        return 0.0;
    }

    protected function getExtraDisplayInfo(): string
    {
        return "Availability:     Always Available (Digital)" . PHP_EOL
            . "Download Link:    " . $this->downloadUrl;
    }

    public function toArray(): array
    {
        return array_merge($this->getCommonArray(), [
            'downloadUrl' => $this->downloadUrl,
        ]);
    }
}