<?php

namespace E2S\Strava;

final class GearId
{
    /** @var string */
    private $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id();
    }


    public static function bikeId(int $id): GearId
    {
        return new self(sprintf('b%d', $id));
    }
}
