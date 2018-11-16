<?php

namespace E2S\Endomondo\Api;

use E2S\AbstractIntegrationTest;

class WorkoutRestApiIntegrationTest extends AbstractIntegrationTest
{
    /** @var WorkoutRestApi */
    private $workoutApi;

    protected function setUp()
    {
        $this->workoutApi = $this->workoutsApi();
    }

    /**
     * @test
     */
    public function shouldGetWorkouts()
    {
        $workouts = $this->workoutApi->workouts(new Filter(Sport::cyclingSport()), 10, 10);

        $this->assertInternalType('array', $workouts);
        foreach ($workouts as $workout) {
            $this->assertInstanceOf(Workout::class, $workout);
        }
    }

    /**
     * @test
     */
    public function shouldExportWorkout()
    {
        $workouts = $this->workoutApi->workouts(null, 1, 0);
        $workout = array_pop($workouts);
        if (!$workout) {
            $this->markTestSkipped('Could not find any workout');
        }

        $file = $this->workoutApi->export($workout->id());
        $this->assertEquals($workout->id(), $file->id());
        $this->assertEquals(Format::gpx(), $file->format());
        $this->assertNotEmpty($file->data());
    }
}
