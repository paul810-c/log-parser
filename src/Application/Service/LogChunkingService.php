<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Contract\LogFileChunkerInterface;

class LogChunkingService
{
    public function __construct(private readonly LogFileChunkerInterface $logFileChunker) {}

    public function chunkLogFile(string $filePath, int $chunkSize): array
    {
        return $this->logFileChunker->chunk($filePath, $chunkSize);
    }
}