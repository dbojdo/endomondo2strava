<?php

namespace E2S\Strava;

final class RideType
{
    /** @var int */
    private $type;

    private function __construct(int $type)
    {
        $this->type = $type;
    }

    public static function ride(): RideType
    {
        return new self(10);
    }

    public static function race(): RideType
    {
        return new self(11);
    }

    public static function workout(): RideType
    {
        return new self(12);
    }

    public function __toString(): string
    {
        return (string)$this->type;
    }
}
