<?php

declare(strict_types=1);

namespace App\Dto;

use DateTime;
use JsonSerializable;

class Result implements JsonSerializable
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $numbers;

    /**
     * Result constructor.
     * @param string $type
     * @param DateTime $date
     * @param string $numbers
     */
    public function __construct(string $type, DateTime $date, string $numbers)
    {
        $this->type = $type;
        $this->date = $date;
        $this->numbers = $numbers;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'date' => $this->date->format('Y-m-d'),
            'numbers' => $this->numbers,
        ];
    }
}