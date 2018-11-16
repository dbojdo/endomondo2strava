<?php

namespace E2S\Endomondo\Api;

final class Workout
{
    /** @var WorkoutId */
    private $id;

    /** @var \DateTime */
    private $date;

    /** @var Sport */
    private $sport;

    /**
     * @param WorkoutId $id
     * @param \DateTime $date
     * @param Sport $sport
     */
    public function __construct(WorkoutId $id, \DateTime $date, Sport $sport)
    {
        $this->id = $id;
        $this->date = $date;
        $this->sport = $sport;
    }

    public function id(): WorkoutId
    {
        return $this->id;
    }

    public function date(): \DateTime
    {
        return $this->date;
    }

    public function sport(): Sport
    {
        return $this->sport;
    }

    public function __toString(): string
    {
        return (string)$this->id();
    }
}
