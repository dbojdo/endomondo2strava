<?php

namespace E2S\Strava;

final class RideActivity extends AbstractActivity implements Activity
{
    /** @var RideType */
    private $rideType;

    /** @var bool */
    private $indoor;

    public function __construct(\SplFileInfo $file, RideType $rideType = null, GearId $bikeId = null, bool $private = false, $commute = false, $indoor = false)
    {
        parent::__construct($file, $private, $commute, $bikeId);

        $this->rideType = $rideType;
        $this->indoor = $indoor;
    }

    /**
     * @return RideType
     */
    public function rideType(): RideType
    {
        return $this->rideType;
    }

    /**
     * @return bool
     */
    public function indoor(): bool
    {
        return $this->indoor;
    }

    public function sport(): Sport
    {
        return Sport::ride();
    }
}
