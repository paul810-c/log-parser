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
        $this->fileHandler->openFile($chunkPath);
        $totalLines = $this->fileHandler->getTotalLines($chunkPath);
        //dump($totalLines);
        $currentLine = 0;
        $batch = [];

        try {
            while ($currentLine < $totalLines) {
                $lines = $this->fileHandler->readLines($currentLine, $this->batchSize);

                foreach ($lines as $line) {
                    try {
                        $logEntry = $this->logParser->parse($line);
                        $batch[] = $logEntry;

                        if (count($batch) >= $this->batchSize) {
                            $this->logRepository->saveBatch($batch);
                            $batch = [];
                        }
                    } catch (\Exception $e) {
                        dump($line);
                        continue;
                    }
                }

                $currentLine += count($lines);
            }

            if (!empty($batch)) {
                $this->logRepository->saveBatch($batch);
            }
        } finally {
            $this->fileHandler->closeFile();
        }
    }
}