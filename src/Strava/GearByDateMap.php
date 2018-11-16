<?php

namespace E2S\Strava;

class GearByDateMap
{
    /** @var GearId[] */
    private $gears;

    public function __construct()
    {
        $this->gears = [];
    }

    public function addGear(GearId $gearId, \DateTime $dateTo)
    {
        $this->gears[$dateTo->format('YmdHis')] = $gearId;
        ksort($this->gears);
    }

    /**
     * @param \DateTime $date
     * @return GearId|null
     */
    public function gearId(\DateTime $date)
    {
        foreach ($this->gears as $dateString => $gearId) {
            $gearDateTo = \DateTime::createFromFormat('YmdHis', $dateString);
            if ($gearDateTo < $date) {
                continue;
            }

            return $gearId;
        }

        $gearIds = $this->gears;
        return array_pop($gearIds);
    }
}