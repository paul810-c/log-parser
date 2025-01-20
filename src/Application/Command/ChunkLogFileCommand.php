<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Contract\LogFileChunkerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:chunk-log-file',
    description: 'Splits a large log file into smaller chunks.'
)]
class ChunkLogFileCommand extends Command
{
    public function __construct(private readonly LogFileChunkerInterface $chunker)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'Path to the log file')
            ->addArgument('chunkSize', InputArgument::OPTIONAL, 'Number of lines per chunk', 100000);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('file');
        $chunkSize = (int)$input->getArgument('chunkSize');

        try {
            $chunks = $this->chunker->chunk($filePath, $chunkSize);
            $output->writeln('<info>Chunks created:</info>');
            foreach ($chunks as $chunk) {
                $output->writeln($chunk);
            }
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('<error>Error:</error> ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}