<?php

declare(strict_types=1);

namespace App\Domain\Contract;

interface ChunkProcessorInterface
{
    public function process(string $chunkPath): void;
}