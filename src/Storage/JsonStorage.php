<?php

declare(strict_types=1);

require_once __DIR__ . '/StorageInterface.php';

class JsonStorage implements StorageInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function loadAll(): array
    {
        // file_exists: Checks Whether A File Or Directory Exists On Disk.
        if (!file_exists($this->filePath)) {
            // This Function From https://www.php.net/manual/en/function.file-exists.php
            return [];
        }

        // file_get_contents: Reads The Entire Contents Of A File Into A String.
        $content = file_get_contents($this->filePath);
        // This Function From https://www.php.net/manual/en/function.file-get-contents.php
        if ($content === false || trim($content) === '') {
            return [];
        }

        // json_decode: Decodes A JSON String Into A PHP Associative Array.
        $decodedData = json_decode($content, true);
        // This Function From https://www.php.net/manual/en/function.json-decode.php

        // is_array: Checks Whether A Variable Is A Valid Array.
        if (!is_array($decodedData)) {
            return [];
        }

        return $decodedData;
    }

    public function saveAll(array $items): void
    {
        // json_encode: Converts A PHP Array Into A Formatted JSON String.
        $jsonContent = json_encode($items, JSON_PRETTY_PRINT);
        if ($jsonContent === false) {
            throw new RuntimeException("Error: Failed to encode catalog data to JSON.");
        }

        file_put_contents($this->filePath, $jsonContent);
        // This Function From https://www.php.net/manual/en/function.file-put-contents.php
    }
}