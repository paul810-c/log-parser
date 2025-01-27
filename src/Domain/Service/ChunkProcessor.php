<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Contract\ChunkProcessorInterface;
use App\Domain\Contract\FileHandlerInterface;
use App\Domain\Contract\LogParserInterface;
use App\Domain\Contract\LogRepositoryInterface;

class ChunkProcessor implements ChunkProcessorInterface
{
    public function __construct(
        private LogParserInterface $logParser,
        private LogRepositoryInterface $logRepository,
        private FileHandlerInterface $fileHandler,
        private int $batchSize
    ) {}

    public function process(string $chunkPath): void
    {
        // TODO: Implement process() method.
    }
}