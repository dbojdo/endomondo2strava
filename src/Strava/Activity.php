<?php

namespace E2S\Strava;

interface Activity
{
    public function file(): \SplFileInfo;

    public function sport(): Sport;

    public function isPrivate(): bool;

    public function commute(): bool;

    public function dataType(): string;

    /**
     * @return GearId|null
     */
    public function gearId();
}