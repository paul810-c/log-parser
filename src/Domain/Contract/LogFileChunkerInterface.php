<?php

declare(strict_types=1);

namespace App\Domain\Contract;

interface LogFileChunkerInterface
{
    public function chunk(string $filePath, int $chunkSize): array;
}