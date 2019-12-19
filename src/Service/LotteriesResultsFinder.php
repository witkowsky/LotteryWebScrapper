<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Result;

class LotteriesResultsFinder implements LotteriesResultsFinderInterface
{
    /**
     * @var []
     */
    private $lotterySites;

    public function __construct(iterable $lotterySites)
    {
        foreach ($lotterySites as $lotterySite) {
            $this->lotterySites[] = $lotterySite;
        }
    }

    /**
     * @return Result[]
     */
    public function findResults(): array
    {
        $results = array_map(
            function (LotteryResultsSiteInterface $lotteryResultsSite) {
                return $lotteryResultsSite->fetchResults();
            },
            $this->lotterySites
        );

        return array_merge(...$results);
    }
}