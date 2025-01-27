<?php

declare(strict_types=1);

namespace App\Domain\Contract;

use App\Domain\Model\LogEntry;

interface LogParserInterface
{
    public function parse(string $line): LogEntry;
}