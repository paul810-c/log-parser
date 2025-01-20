<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Contract\PathManagerInterface;
use App\Shared\Enum\DirectoryType;

class PathManager implements PathManagerInterface
{
    public function __construct(private readonly string $baseDir)
    {
    }

    public function getDirectoryPath(DirectoryType $type): string
    {
        return sprintf('%s/%s', $this->baseDir, $type->value);
    }

    public function createChunkDirectory(): string
    {
        $chunkDir = $this->getDirectoryPath(DirectoryType::LOG_CHUNKS) . '_' . uniqid();

        if (!mkdir($chunkDir, 0777, true) && !is_dir($chunkDir)) {
            die(sprintf('Failed to create directory: %s', $chunkDir));
            // throw new LogFileProcessingException(sprintf('Failed to create directory: %s', $chunkDir));
        }

        return $chunkDir;
    }

    public function getChunkFilePath(string $chunkDir, int $chunkIndex): string
    {
        return sprintf('%s/chunk_%d.log', $chunkDir, $chunkIndex);
    }
}