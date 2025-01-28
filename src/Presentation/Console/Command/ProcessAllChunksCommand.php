<?php

declare(strict_types=1);

namespace App\Presentation\Console\Command;

use App\Application\Message\ChunkProcessingMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:process-all-chunks',
    description: 'Dispatches chunk log files processing jobs to the queue.'
)]
class ProcessAllChunksCommand extends Command
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('chunkDir', InputArgument::REQUIRED, 'Path to the directory containing chunks');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $chunkDir = $input->getArgument('chunkDir');

        if (!is_dir($chunkDir)) {
            $output->writeln("<error>Invalid chunk directory: $chunkDir</error>");
            return Command::FAILURE;
        }

        $chunks = glob($chunkDir . '/*.log');

        if (empty($chunks)) {
            $output->writeln("<info>No chunks found in directory: $chunkDir</info>");
            return Command::SUCCESS;
        }

        foreach ($chunks as $chunk) {
            $output->writeln("<info>Dispatching job for chunk: $chunk</info>");
            $this->messageBus->dispatch(new ChunkProcessingMessage($chunk));
        }

        $output->writeln("<info>All chunks have been dispatched.</info>");
        return Command::SUCCESS;
    }
}
