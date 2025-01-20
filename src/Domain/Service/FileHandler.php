<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Contract\FileHandlerInterface;

class FileHandler implements FileHandlerInterface
{
    private ?\SplFileObject $file = null;

    public function openFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            die("File not found: $filePath");
            // throw new LogFileProcessingException("File not found: $filePath");
        }

        $this->file = new \SplFileObject($filePath, 'r');
    }

    public function readLines(int $startLine, int $numLines): array
    {
        if ($this->file === null) {
            die("No file is open for reading.");
            // throw new LogFileProcessingException("No file is open for reading.");
        }

        $this->file->seek($startLine);
        $lines = [];

        for ($i = 0; $i < $numLines && !$this->file->eof(); $i++) {
            $lines[] = $this->file->current();
            $this->file->next();
        }

        return $lines;
    }

    public function closeFile(): void
    {
        $this->file = null;
    }

    public function getTotalLines(string $filePath): int
    {
        $lineCount = 0;
        $file = fopen($filePath, 'r');

        while (!feof($file)) {
            fgets($file);
            $lineCount++;
        }

        fclose($file);

        return $lineCount;
    }
}