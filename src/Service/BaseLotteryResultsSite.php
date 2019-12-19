<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Result;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class BaseLotteryResultsSite
 *
 * @package App\Service
 */
abstract class BaseLotteryResultsSite implements LotteryResultsSiteInterface
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * BaseLotteryResultsSite constructor.
     *
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return Result[]
     *
     * @throws GuzzleException
     */
    public function fetchResults(): array
    {
        $html = $this->fetchSite();
        return $this->extractResults($html);
    }

    /**
     * @return string
     *
     * @throws GuzzleException
     */
    private function fetchSite(): string
    {
        $response = $this->httpClient->request('GET', $this->getWebsiteUrl());
        return (string) $response->getBody();
    }

    /**
     * @param string $html
     *
     * @return Result[]
     */
    abstract protected function extractResults(string $html): array;

    /**
     * @return string
     */
    abstract protected function getWebsiteUrl(): string;
}