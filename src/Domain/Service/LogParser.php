<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Contract\LogParserInterface;
use App\Domain\Model\LogEntry;

class LogParser implements LogParserInterface
{
    public function parse(string $line): LogEntry
    {
        //$pattern = '/^(?<serviceName>[^\\s]+) - - \\[(?<date>[^\\]]+)] \\\"(?<method>[^\\s]+) (?<endpoint>[^\\s]+) [^\\\"]+\\\" (?<statusCode>\\d+)/';
        // $pattern = '/^(?<serviceName>[^\\s]+) - - \\[(?<date>[^\\]]+)] \\\"(?<method>[^\\s]+) (?<endpoint>[^\\s]+) [^\\\"]+\\\" (?<statusCode>\\d+)/';
        $pattern = '/^(?<serviceName>[^\s]+) - - \[(?<date>[^\]]+)] "(?<method>[^\s]+) (?<endpoint>[^\s]+) [^"]+" (?<statusCode>\d+)/';
        if (!preg_match($pattern, $line, $matches)) {
            //dd($line);
            throw new \InvalidArgumentException("Invalid log line format: $line");
        }

        $timestamp = \DateTimeImmutable::createFromFormat('d/M/Y:H:i:s O', $matches['date']);
        if (!$timestamp) {
            throw new \RuntimeException("Failed to parse timestamp: {$matches['date']}");
        }

        return new LogEntry(
            $matches['serviceName'],
            $timestamp,
            $matches['method'],
            $matches['endpoint'],
            (int)$matches['statusCode']
        );
    }
}