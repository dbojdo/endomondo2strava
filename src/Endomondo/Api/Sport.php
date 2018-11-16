<?php

namespace E2S\Endomondo\Api;

final class Sport
{
    /** @var int */
    private $sport;

    private function __construct(int $sport)
    {
        $this->sport = $sport;
    }

    public static function cyclingSport()
    {
        return new self(2);
    }

    public static function cyclingTransport()
    {
        return new self(1);
    }

    public static function running()
    {
        return new self(0);
    }

    public static function walking()
    {
        return new self(18);
    }

    public static function parse($sportId)
    {
        return new self((int)$sportId);
    }

    public function __toString(): string
    {
        return (string)$this->sport;
    }
}