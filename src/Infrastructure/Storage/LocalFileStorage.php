<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage;

use App\Domain\Contract\FileStorageInterface;
use Symfony\Component\Filesystem\Filesystem;

class LocalFileStorage implements FileStorageInterface
{
    public function __construct(private readonly Filesystem $filesystem)
    {
    }

    public function createDirectory(string $directory): void
    {
        try {
            $this->filesystem->mkdir($directory, 0777);
        } catch (\Exception $e) {
            // throw new LogFileProcessingException("Failed to create directory: $directory");
        }
    }

    public function writeToFile(string $filePath, string $content): void
    {
        if (file_put_contents($filePath, $content) === false) {
            die("d");
            // throw new LogFileProcessingException("Failed to write to file: $filePath");
        }
    }
}