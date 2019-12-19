<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Result;

/**
 * Interface LotteriesResultsFinderInterface
 *
 * @package App\Service
 */
interface LotteriesResultsFinderInterface
{
    /**
     * @return Result[]
     */
    public function findResults(): array;
}