<?php

declare(strict_types=1);

namespace App\Domain\Contract;

interface LogRepositoryInterface
{
    public function saveBatch(array $logEntries): void;
}