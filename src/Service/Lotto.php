<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Result;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Lotto implements LotteryResultsSiteInterface
{
    private const URL = 'https://www.lotto.pl/lotto/wyniki-i-wygrane';
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * Lotto constructor.
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return Result[]
     */
    public function fetchResults(): array
    {
        $html = $this->fetchSite();
        $crawler = new Crawler($html);
        return $crawler->filter('.wynik')->each(
            function (Crawler $wynik) {
                $type = $wynik->filter('td:nth-child(1) img')->attr('alt');
                $date = $wynik->filter('td:nth-child(3)')->text();
                $date = substr($date, 0, strpos($date, ','));
                $numbers = $wynik->filter('td:nth-child(4) div.sortrosnaco span')
                    ->each(function (Crawler $number) {
                        return $number->text();
                    });
                return new Result($type, \DateTime::createFromFormat('d-m-y', $date), join(',', $numbers));
            }
        );
    }

    /**
     * @return string
     */
    private function fetchSite(): string
    {
        $response = $this->httpClient->request('GET', self::URL);
        return (string) $response->getBody();
    }
}