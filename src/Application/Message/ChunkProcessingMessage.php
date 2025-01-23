<?php

declare(strict_types=1);

namespace App\Application\Message;

class ChunkProcessingMessage
{
    public function __construct(private string $chunkPath)
    {
    }

    public function getChunkPath(): string
    {
        return $this->chunkPath;
    }
}