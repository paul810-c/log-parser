<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Message\ChunkProcessingMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(method: 'handle')]
class ChunkProcessingHandler
{
    public function __construct(/* private ChunkProcessorInterface $chunkProcessor */)
    {
    }

    public function handle(ChunkProcessingMessage $message): void
    {
        die("procesasdasdasdasdasdasdasdasds!");
        // $chunkPath = $message->getChunkPath();
        // $this->chunkProcessor->process($chunkPath);
    }
}
