<?php

declare(strict_types=1);

namespace App\Domain\Contract;

interface FileHandlerInterface
{
    public function openFile(string $filePath): void;

    public function readLines(int $startLine, int $numLines): array;

    public function closeFile(): void;

    public function getTotalLines(string $filePath): int;
}