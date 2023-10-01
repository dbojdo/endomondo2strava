<?php

namespace E2S\Strava;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use Strava\API\Client;
use Strava\API\Service\REST;

class ActivitiesUploaderIntegrationTest extends TestCase
{
    /** @var ActivitiesUploader */
    private $uploader;

    protected function setUp()
    {
        $this->uploader = new ActivitiesUploader(
            $this->client(),
            new Logger(
                'activity',
                [
                    new StreamHandler(__DIR__.'/../resources/upload.log')
                ]
            )
        );
    }

    /**
     * @return Client
     * @throws \Exception
     */
    private function client()
    {
        $token = getenv('strava.token');
        if ($token == 'changeme') {
            $this->markTestSkipped('Strava Token must be set.');
        }

        $adapter = new \Pest('https://www.strava.com/api/v3');
        $service = new REST(getenv('strava.token'), $adapter);

        return new Client($service);
    }

    /**
     * @test
     */
    public function shouldUploadActivity()
    {
        $activitiesLoader = new ActivitiesLoader(
            __DIR__.'/../resources/activities',
            $factory = new RideActivityFactory(
                $gearMap = new GearByDateMap()
            )
        );

        $gearMap->addGear(GearId::bikeId(4884414), new \DateTime('2020-08-28 12:00:00')); // defy 1
        $gearMap->addGear(GearId::bikeId(4884419), new \DateTime('2017-08-28 12:00:00')); // defy 4
        $gearMap->addGear(GearId::bikeId(4884424), new \DateTime('2016-02-07 00:00:00')); // carrera
        $gearMap->addGear(GearId::bikeId(4884422), new \DateTime('2014-11-26 00:00:00')); // speci
        $gearMap->addGear(GearId::bikeId(4884421), new \DateTime('2014-09-19 00:00:00')); // herkules
        $gearMap->addGear(GearId::bikeId(4884417), new \DateTime('2013-04-01 00:00:00')); // puch

        $activities = $activitiesLoader->activities();

        $this->uploader->uploadActivities($activities);
    }
}