<?php

namespace E2S\Endomondo;

use E2S\Endomondo\Api\Filter;
use E2S\Endomondo\Api\Format;
use E2S\Endomondo\Api\Workout;
use E2S\Endomondo\Api\WorkoutApi;
use E2S\Endomondo\Api\WorkoutFile;

class WorkoutsDownloader
{
    /** @var WorkoutApi */
    private $workoutsApi;

    /** @var string */
    private $workoutsDir;

    /**
     * @param WorkoutApi $workoutsApi
     * @param string $workoutsDir
     */
    public function __construct(WorkoutApi $workoutsApi, string $workoutsDir)
    {
        $this->workoutsApi = $workoutsApi;
        $this->workoutsDir = $workoutsDir;
    }

    /**
     * @param Filter|null $filter
     * @param Format|null $format
     * @return \SplFileInfo[]
     */
    public function download(Filter $filter = null, Format $format = null)
    {
        $limit = 100;
        $offset = 0;

        $files = [];
        while($workouts = $this->workoutsApi->workouts($filter, $limit, $offset)) {
            foreach ($workouts as $workout) {
                $workoutFile = $this->workoutsApi->export($workout->id(), $format);
                $files[] = $this->save($workout, $workoutFile);
            }
            $offset += $limit;
            sleep(5);
        }

        return $files;
    }

    private function save(Workout $workout, WorkoutFile $workoutFile)
    {
        $this->ensureDir();

        $filename = sprintf(
            '%s_%d.%s',
            $workout->date()->format('YmdHis'),
            (string)$workoutFile->id(),
            strtolower($workoutFile->format())
        );

        file_put_contents(
            $pathname = sprintf('%s/%s', $this->workoutsDir, $filename),
            $workoutFile->data()
        );

        return new \SplFileInfo($pathname);
    }

    private function ensureDir()
    {
        if (is_dir($this->workoutsDir)) {
            return;
        }

        @mkdir($this->workoutsDir, 0755, true);
    }
}
