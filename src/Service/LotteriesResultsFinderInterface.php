<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Result;

interface LotteriesResultsFinderInterface
{
    /**
     * @return Result[]
     */
    public function findResults(): array;
}