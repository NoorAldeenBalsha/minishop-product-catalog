<?php

declare(strict_types=1);

interface StorageInterface
{
    public function loadAll(): array;

    public function saveAll(array $items): void;
}