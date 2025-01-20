<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Contract\FileHandlerInterface;
use App\Domain\Contract\FileStorageInterface;
use App\Domain\Contract\LogFileChunkerInterface;
use App\Domain\Contract\PathManagerInterface;

class LogFileChunker implements LogFileChunkerInterface
{
    public function __construct(
        private readonly FileHandlerInterface $fileHandler,
        private readonly FileStorageInterface $fileStorage,
        private readonly PathManagerInterface $pathManager
    )
    {
    }

    public function chunk(string $filePath, int $chunkSize): array
    {
        $chunks = [];
        $chunkDir = $this->pathManager->createChunkDirectory();

        $this->fileHandler->openFile($filePath);
        $totalLines = $this->fileHandler->getTotalLines($filePath);
        $currentLine = 0;
        $chunkIndex = 0;

        while ($currentLine < $totalLines) {
            $lines = $this->fileHandler->readLines($currentLine, $chunkSize);

            $chunkFile = $this->pathManager->getChunkFilePath($chunkDir, $chunkIndex);
            $this->fileStorage->writeToFile($chunkFile, implode('', $lines));
            $chunks[] = $chunkFile;

            $currentLine += $chunkSize;
            $chunkIndex++;
        }

        $this->fileHandler->closeFile();

        return $chunks;
    }
}