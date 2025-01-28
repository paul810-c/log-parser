<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Infrastructure\Repository\LogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'log_entries')]
#[ORM\Entity(repositoryClass: LogRepository::class)]
class LogEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]  // This ensures the ID is generated automatically
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 55)]
    private string $serviceName;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $timestamp;

    #[ORM\Column(type: 'string', length: 10)]
    private string $httpMethod;

    #[ORM\Column(type: 'string', length: 255)]
    private string $endpoint;

    #[ORM\Column(type: 'integer')]
    private int $statusCode;

    public function __construct(
        string $serviceName,
        \DateTimeImmutable $timestamp,
        string $httpMethod,
        string $endpoint,
        int $statusCode
    ) {
        $this->serviceName = $serviceName;
        $this->timestamp = $timestamp;
        $this->httpMethod = $httpMethod;
        $this->endpoint = $endpoint;
        $this->statusCode = $statusCode;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function getTimestamp(): \DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
