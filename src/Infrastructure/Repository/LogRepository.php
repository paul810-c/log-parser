<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Contract\LogRepositoryInterface;
use App\Domain\Model\LogEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

class LogRepository extends ServiceEntityRepository implements LogRepositoryInterface
{
    private Connection $dbConnection;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogEntry::class);
        $this->dbConnection = $this->getEntityManager()->getConnection();
    }

    public function saveBatch(array $logEntries): void
    {
        if (empty($logEntries)) {
            return;
        }

        $sql = 'INSERT INTO log_entries (service_name, timestamp, http_method, endpoint, status_code) VALUES ';
        $values = [];
        $params = [];

        foreach ($logEntries as $index => $logEntry) {
            /** @var LogEntry $logEntry */
            $values[] = '(?, ?, ?, ?, ?)';
            $params[] = $logEntry->getServiceName();
            $params[] = $logEntry->getTimestamp()->format('Y-m-d H:i:s');
            $params[] = $logEntry->getHttpMethod();
            $params[] = $logEntry->getEndpoint();
            $params[] = $logEntry->getStatusCode();
        }

        $sql .= implode(', ', $values);

        $this->dbConnection->beginTransaction();

        try {
            $this->dbConnection->executeStatement($sql, $params);
            $this->dbConnection->commit();
        } catch (\Throwable $e) {
            dd($e->getMessage());
            $this->dbConnection->rollBack();
            throw $e;
        }
    }
}