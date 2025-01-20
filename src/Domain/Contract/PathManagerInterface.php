<?php

declare(strict_types=1);

namespace App\Domain\Contract;

use App\Shared\Enum\DirectoryType;

interface PathManagerInterface
{
    public function getDirectoryPath(DirectoryType $type): string;

    public function createChunkDirectory(): string;

    public function getChunkFilePath(string $chunkDir, int $chunkIndex): string;
}