<?php

namespace Strava;

use PHPUnit\Framework\TestCase;
use Strava\API\Client;
use Strava\API\Service\REST;

class StatsProviderTest extends TestCase
{
    /**
     * @test
     */
    public function prepareStats()
    {
//        $c = new \GuzzleHttp\Client(['base_uri' => 'https://www.strava.com/api/v3/', 'headers' => ['Authorization' => 'Bearer '.getenv('strava.token')]]);
//        $r = $c->get('athlete/activities');
//var_dump($r);
//die();
        $x = new \DateTime('2020-03-29');

        $activities = $this->client()->getAthleteActivities(null, $x->getTimestamp(), 1, 200);

        $distance = 0;
        $movingTime = 0;
        $sufferScore = 0;
        $kJ = 0;
        $trainings = 0;

        foreach ($activities as $activity) {
            if (strpos($activity['name'], 'Build Me Up') !== false || strpos($activity['name'], 'FTP') !== false) {
                var_dump($activity['name']);
                $distance += $activity['distance'];
                $movingTime += $activity['moving_time'];
                $sufferScore += $activity['suffer_score'];
                $kJ += $activity['kilojoules'];
                $trainings++;
            }
        }

        var_dump('distance [mi]: ' . $distance / 1000 / 1.61);
        var_dump('moving time [h]: ' . $movingTime / 3600);
        var_dump('suffer score: ' . $sufferScore);
        var_dump('kJ:' . $kJ);
        var_dump('kcal: ' . $kJ / 4.184 * 4);
        var_dump('total workouts: ' . $trainings);

        // 239 ->
        // 88.7 -> 79.5 (-9.2)
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

        $adapter = new \GuzzleHttp\Client(['base_uri' => 'https://www.strava.com/api/v3/']);
        $service = new REST('99cbb09b53dcf2a55bbde988c156d011ddc79868', $adapter);
//        3a5bb3c6cc785462da28137a78c5ac23b9bac9d8
        return new Client($service);
    }
}

//{
//    "token_type": "Bearer",
//    "expires_at": 1591737762,
//    "expires_in": 21600,
//    "refresh_token": "69f85050aca65a6b71c72893f539c803870239ed",
//    "access_token": "b973333b8246c301d01895bad70dde01c42304be",
//    "athlete": {
//    "id": 7886459,
//        "username": "dbojdo",
//        "resource_state": 2,
//        "firstname": "Daniel",
//        "lastname": "Bojdo",
//        "city": "London",
//        "state": "",
//        "country": "United Kingdom",
//        "sex": "M",
//        "premium": true,
//        "summit": true,
//        "created_at": "2015-02-09T09:20:37Z",
//        "updated_at": "2020-06-02T10:19:59Z",
//        "badge_type_id": 1,
//        "profile_medium": "https://dgalywyr863hv.cloudfront.net/pictures/athletes/7886459/2397699/1/medium.jpg",
//        "profile": "https://dgalywyr863hv.cloudfront.net/pictures/athletes/7886459/2397699/1/large.jpg",
//        "friend": null,
//        "follower": null
//    }
//}