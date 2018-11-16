<?php

namespace E2S\Strava;

final class Sport
{
    /** @var string */
    private $sport;

    private function __construct(string $sport)
    {
        $this->sport = $sport;
    }

    public static function ride(): Sport
    {
        return new self('Ride');
    }

    public static function run(): Sport
    {
        return new self('Run');
    }

    public function __toString(): string
    {
        return $this->sport;
    }
}