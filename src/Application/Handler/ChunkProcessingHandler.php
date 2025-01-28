<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Message\ChunkProcessingMessage;
use App\Domain\Contract\ChunkProcessorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

#[AsMessageHandler(method: 'handle')]
class ChunkProcessingHandler
{
    public function __construct(private ChunkProcessorInterface $chunkProcessor,
                                private LoggerInterface $logger
    )
    {
    }

    public function handle(ChunkProcessingMessage $message): void
    {
        $chunkPath = $message->getChunkPath();

        try {
            $this->chunkProcessor->process($chunkPath);
        } catch (\Throwable $e) {
            $this->logger->error('Error processing chunk', [
                'chunkPath' => $chunkPath,
                'error' => $e->getMessage(),
            ]);

            if ($this->isUnrecoverable($e)) {
                throw new UnrecoverableMessageHandlingException(
                    sprintf('Unrecoverable error while processing chunk: %s', $chunkPath),
                    0,
                    $e
                );
            }

            throw $e;
        }
    }

    private function isUnrecoverable(\Throwable $e): bool
    {
        // Define criteria for unrecoverable exceptions
        // Example: If the error is related to missing files or invalid input
        return $e instanceof \InvalidArgumentException || $e instanceof \RuntimeException;
    }
}
