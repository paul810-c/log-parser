<?php

declare(strict_types=1);

namespace App\Domain\Contract;

interface FileStorageInterface
{
    public function createDirectory(string $directory): void;

    public function writeToFile(string $filePath, string $content): void;
}