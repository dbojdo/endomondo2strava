<?php

namespace E2S\Strava;

class RideActivityFactory
{
    /** @var GearByDateMap */
    private $gearMap;

    /**
     * @param GearByDateMap $gearMap
     */
    public function __construct(GearByDateMap $gearMap)
    {
        $this->gearMap = $gearMap;
    }

    /**
     * @param \SplFileInfo $file
     * @return Activity
     */
    public function create(\SplFileInfo $file)
    {
        return new RideActivity(
            $file,
            RideType::ride(),
            $this->gearMap->gearId(
                $this->resolveActivityDate($file)
            ),
            false,
            true,
            false
        );
    }

    private function resolveActivityDate(\SplFileInfo $file)
    {
        $basename = $file->getBasename();
        list($dateString) = @explode('_', $basename);
        return \DateTime::createFromFormat('YmdHis', $dateString);
    }
}
