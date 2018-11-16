<?php

namespace E2S\Strava;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Strava\API\Client;

class ActivitiesUploader
{
    /** @var Client */
    private $client;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param Client $client
     * @param LoggerInterface $logger
     */
    public function __construct(Client $client, LoggerInterface $logger = null)
    {
        $this->client = $client;
        $this->logger = $logger ?: new NullLogger();
    }

    /**
     * @param Activity[] $activities
     */
    public function uploadActivities(array $activities)
    {
        $this->countGiant();
        die();

        foreach ($activities as $activity) {
            try {
                $uploadResult = $this->client->uploadActivity(
                    $activity->file()->getPathname(),
                    (string)$activity->sport(),
                    '',
                    '',
                    (int)$activity->isPrivate(),
                    0,
                    (int)$activity->commute(),
                    $activity->dataType(),
                    $activity->file()->getBasename()
                );

                $activityId = $this->activityId($uploadResult['id']);

                if (!$activity->gearId()) {
                    continue;
                }

                $this->client->updateActivity(
                    $activityId,
                    '',
                    (string)$activity->sport(),
                    (int)$activity->isPrivate(),
                    (int)$activity->commute(),
                    0,
                    (string)$activity->gearId(),
                    ''
                );
            } catch (\Exception $e) {
                var_dump($activity->file()->getPathname());
                $this->logger->error(
                    sprintf('%s: %s', $activity->file()->getFilename(), $e->getMessage())
                );
                continue;
            }

            $this->logger->info(
                sprintf('%s: Uploaded', $activity->file()->getFilename())
            );
            unlink($activity->file()->getPathname());
        }
    }

    private function activityId($id)
    {
        do {
            sleep(2);
            $result = $this->client->getActivityUploadStatus($id);
        } while (!($activityId = $result['activity_id']));

        return $activityId;
    }

    private static $activityIds = array (
        776364858
    );

    private function countGiant()
    {
        $distance = 0;
        $distanceNone = 0;

        $activities = 0;
        $activitiesNone = 0;

        $page = 1;

        while ($r = $this->client->getAthleteActivities(null, null, $page, 100)) {
            $page++;
            foreach ($r as $ac) {
                if ($ac['gear_id'] == 'b4890231') {
                    $distance += $ac['distance'];
                    $activities++;
                }

                if (!$ac['gear_id']) {
                    $distanceNone += $ac['distance'];
                    $activitiesNone++;
                }

            }
            var_dump($page);
        }
        var_dump('num: ' . $activities);
        var_dump('km:' . $distance / 1000);

        var_dump('num none: ' . $activitiesNone);
        var_dump('km one:' . $distanceNone / 1000);
    }

    private function updateGear()
    {
        $gearMap = new GearByDateMap();

        $gearMap->addGear(GearId::bikeId(4890231), new \DateTime('2020-08-28 12:00:00')); // defy 1
        $gearMap->addGear(GearId::bikeId(4890233), new \DateTime('2017-08-28 12:00:00')); // defy 5
        $gearMap->addGear(GearId::bikeId(4890235), new \DateTime('2016-02-07 00:00:00')); // carrera
        $gearMap->addGear(GearId::bikeId(4890238), new \DateTime('2014-11-26 00:00:00')); // speci
        $gearMap->addGear(GearId::bikeId(4890239), new \DateTime('2014-09-19 00:00:00')); // herkules
        $gearMap->addGear(GearId::bikeId(4890241), new \DateTime('2013-04-01 00:00:00')); // puch

        $page = 11;
        while ($act = $this->getActivities($page++)) {
            var_dump('Found: '. count($act));
            foreach ($act as $ac) {
//                var_dump('Activity: ' . $ac['id']);
                $date = new \DateTime($ac['start_date']);

                $gearId = $gearMap->gearId($date);

                $this->client->updateActivity(
                    $ac['id'],
                    '',
                    $ac['type'],
                    (int)$ac['private'],
                    (int)$ac['commute'],
                    0,
                    (string)$gearId,
                    ''
                );
            }
            if ($page >= 15) {
                break;
            }
        }
    }

    private function getActivities($page)
    {
        var_dump('Page: '.$page);
        return $this->client->getAthleteActivities(null, null, $page, 100);
    }
}
