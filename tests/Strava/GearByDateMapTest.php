<?php

namespace E2S\Strava;

use PHPUnit\Framework\TestCase;

class GearByDateMapTest extends TestCase
{
    /** @var GearByDateMap */
    private $gearMap;

    protected function setUp()
    {
        $this->gearMap = new GearByDateMap();

        $this->gearMap->addGear(GearId::bikeId(4), date_create('now + 10 years'));
        $this->gearMap->addGear(GearId::bikeId(2), date_create('now - 1 year'));
        $this->gearMap->addGear(GearId::bikeId(3), date_create('now - 8 months'));
        $this->gearMap->addGear(GearId::bikeId(1), date_create('now - 2 years'));
    }

    /**
     * @test
     * @dataProvider gearsByDate
     * @param GearByDateMap $gearMap
     * @param \DateTime $anchorDate
     * @param GearId $expectedGearId
     */
    public function shouldGetProperGearId(GearByDateMap $gearMap, \DateTime $anchorDate, GearId $expectedGearId)
    {
        $this->assertEquals(
            $expectedGearId,
            $gearMap->gearId($anchorDate)
        );

    }

    public function gearsByDate()
    {
        $gearMap = new GearByDateMap();

        $gearMap->addGear($gear4 = GearId::bikeId(4), date_create('now + 10 years'));
        $gearMap->addGear($gear2 = GearId::bikeId(2), date_create('now - 1 year'));
        $gearMap->addGear($gear3 = GearId::bikeId(3), date_create('now - 8 months'));
        $gearMap->addGear($gear1 = GearId::bikeId(1), date_create('now - 2 years'));

        return [
            [
                $gearMap,
                date_create('now - 6 months'),
                $gear4
            ],
            [
                $gearMap,
                date_create('now - 2 months'),
                $gear4
            ],
            [
                $gearMap,
                date_create('now + 2 months'),
                $gear4
            ],
            [
                $gearMap,
                date_create('now - 3 years'),
                $gear1
            ],
            [
                $gearMap,
                date_create('now - 18 months'),
                $gear2
            ],
            [
                $gearMap,
                date_create('now - 9 months'),
                $gear3
            ]
        ];
    }
}
