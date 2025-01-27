<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Contract\LogRepositoryInterface;
use App\Domain\Model\LogEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LogRepository extends ServiceEntityRepository implements LogRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogEntry::class);
    }

    public function saveBatch(array $logEntries): void
    {
        // TODO: Implement saveBatch() method.
    }
}