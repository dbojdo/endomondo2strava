<?php

namespace E2S\Strava;

abstract class AbstractActivity implements Activity
{
    /** @var \SplFileInfo */
    private $file;

    /** @var bool */
    private $private;

    /** @var bool */
    private $commute;

    /** @var GearId */
    private $gearId;

    public function __construct(\SplFileInfo $file, bool $private = false, bool $commute = false, GearId $gearId = null)
    {
        $this->file = $file;
        $this->private = $private;
        $this->commute = $commute;
        $this->gearId = $gearId;
    }

    public function file(): \SplFileInfo
    {
        return $this->file;
    }

    public function isPrivate(): bool
    {
        return $this->private;
    }

    /**
     * @return bool
     */
    public function commute(): bool
    {
        return $this->commute;
    }

    /**
     * @return GearId
     */
    public function gearId()
    {
        return $this->gearId;
    }

    public function dataType(): string
    {
        return 'gpx';
    }
}