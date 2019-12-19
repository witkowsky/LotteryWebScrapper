<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Result;

interface LotteryResultsSiteInterface
{
    /**
     * @return Result[]
     */
    public function fetchResults(): array;
}


