<?php

namespace E2S\Endomondo\Api;

final class WorkoutFile
{
    /** @var WorkoutId */
    private $id;

    /** @var Format */
    private $format;

    /** @var string */
    private $data;

    public function __construct(WorkoutId $id, Format $format, string $data)
    {
        $this->id = $id;
        $this->format = $format;
        $this->data = $data;
    }

    public function id(): WorkoutId
    {
        return $this->id;
    }

    public function format(): Format
    {
        return $this->format;
    }

    public function data(): string
    {
        return $this->data;
    }

    public function __toString(): string
    {
        return $this->data;
    }
}