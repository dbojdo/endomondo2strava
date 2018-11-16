<?php

namespace E2S\Endomondo\Api;

final class Format
{
    /** @var string */
    private $format;

    private function __construct($format)
    {
        $this->format = $format;
    }

    public static function gpx(): Format
    {
        return new self('GPX');
    }

    public static function tcx(): Format
    {
        return new self('TCX');
    }

    public function __toString(): string
    {
        return $this->format;
    }
}