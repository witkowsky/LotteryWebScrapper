<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Result;
use DateTime;
use Exception;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Euromillions
 *
 * @package App\Service
 */
class Euromillions extends BaseLotteryResultsSite
{
    private const URL = 'https://www.elgordo.com/results/euromillonariaen.asp';
    private const TYPE = 'Euromillions';

    /**
     * @param string $html
     *
     * @return Result[]
     *
     * @throws Exception
     */
    protected function extractResults(string $html): array
    {
        $crawler = new Crawler($html);
        $results = $crawler->filter('div.result_big div.body_game div.num span')->each(
            function (Crawler $number) {
                return $number->text();
            }
        );
        $results[] = "+";
        $extraNumbers = $crawler->filter('div.result_big div.body_game div.esp .int-num')->each(
            function (Crawler $number) {
                return $number->text();
            }
        );
        $results = array_merge($results, $extraNumbers);
        $results = join(',', $results);

        $date = $crawler->filter('div.result_big div.body_game > div.c:nth-child(1)')->html();
        $str = htmlentities($date);
        $str = str_replace("&nbsp;", " ", $str);
        $str = html_entity_decode($str);

        $date = substr($str, strpos($str, ', ') + 2);
        $date = new DateTime($date);
        return [
            new Result(self::TYPE, $date, $results)
        ];
    }

    /**
     * @return string
     */
    protected function getWebsiteUrl(): string
    {
        return self::URL;
    }
}