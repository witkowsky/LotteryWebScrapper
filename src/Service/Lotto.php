<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Result;
use DateTime;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Lotto
 *
 * @package App\Service
 */
class Lotto extends BaseLotteryResultsSite
{
    private const URL = 'https://www.lotto.pl/lotto/wyniki-i-wygrane';

    /**
     * @param string $html
     *
     * @return Result[]
     */
    protected function extractResults(string $html): array
    {
        $crawler = new Crawler($html);
        return $crawler->filter('.wynik')->each(
            function (Crawler $crawler) {
                $type = $crawler->filter('td:nth-child(1) img')->attr('alt');
                $date = $crawler->filter('td:nth-child(3)')->text();
                $date = substr($date, 0, strpos($date, ','));
                $numbers = $crawler->filter('td:nth-child(4) div.sortrosnaco span')
                    ->each(function (Crawler $number) {
                        return $number->text();
                    });
                return new Result($type, DateTime::createFromFormat('d-m-y', $date), join(',', $numbers));
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