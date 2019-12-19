<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Result;
use DateTime;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Eurojackpot
 *
 * @package App\Service
 */
class Eurojackpot extends BaseLotteryResultsSite
{
    private const URL = 'https://www.lotto.pl/eurojackpot/wyniki-i-wygrane';
    private const TYPE = 'Eurojackpot';

    /**
     * @param string $html
     *
     * @return Result[]
     */
    protected function extractResults(string $html): array
    {
        $crawler = new Crawler($html);
        return $crawler->filter('.wynik')->each(
            function (Crawler $wynik) {
                $date = $wynik->filter('td:nth-child(2)')->text();
                $date = substr($date, 0, strpos($date, ','));
                $numbers = $wynik->filter('td:nth-child(3) div.sortrosnaco span')
                    ->each(function (Crawler $number) {
                        return $number->text();
                    });
                return new Result(
                    self::TYPE,
                    DateTime::createFromFormat('d-m-y', $date),
                    join(',', $numbers)
                );
            }
        );
    }

    /**
     * @return string
     */
    protected function getWebsiteUrl(): string
    {
        return self::URL;
    }
}