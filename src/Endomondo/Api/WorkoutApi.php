<?php

namespace E2S\Endomondo\Api;

interface WorkoutApi
{
    /**
     * @param Filter $filter
     * @param int $limit
     * @param int $offset
     * @return Workout[]
     */
    public function workouts(Filter $filter = null, int $limit = null, int $offset = null): array;

    /**
     * @param WorkoutId $id
     * @param Format $format
     * @return WorkoutFile
     */
    public function export(WorkoutId $id, Format $format = null);
}
