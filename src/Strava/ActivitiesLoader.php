<?php

namespace E2S\Strava;

class ActivitiesLoader
{
    /** @var string */
    private $dir;

    /** @var RideActivityFactory */
    private $activityFactory;

    public function __construct(string $dir, RideActivityFactory $activityFactory)
    {
        $this->dir = new \DirectoryIterator($dir);
        $this->activityFactory = $activityFactory;
    }

    /**
     * @return Activity[]
     */
    public function activities()
    {
        $activities = [];
        foreach ($this->dir as $file) {
            if ($file->isDot()) {
                continue;
            }

            $file = new \SplFileInfo(realpath($file->getPathname()));
            $activities[$file->getFilename()] = $this->activityFactory->create($file);
        }

        ksort($activities);
        return array_values($activities);
    }
}
