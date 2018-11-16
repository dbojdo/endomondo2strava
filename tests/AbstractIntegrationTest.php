<?php

namespace E2S;

use E2S\Endomondo\Api\Credentials;
use E2S\Endomondo\Api\WorkoutRestApi;
use Fabulator\Endomondo\EndomondoApi;
use PHPUnit\Framework\TestCase;

abstract class AbstractIntegrationTest // extends TestCase
{
    protected function workoutsApi()
    {
        return new WorkoutRestApi(
            new EndomondoApi(),
            $this->credentials()
        );
    }

    private function credentials()
    {
        $user = getenv('endomondo.username');
        $password = getenv('endomondo.password');

        if (in_array('changeme', [$user, $password])) {
            $this->markTestSkipped('Credentials has not been set');
        }

        return new Credentials($user, $password);
    }
}