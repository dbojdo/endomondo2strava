<?php

namespace E2S\Endomondo\Api;

final class WorkoutId
{
    /** @var int */
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return (string)$this->id();
    }
}
