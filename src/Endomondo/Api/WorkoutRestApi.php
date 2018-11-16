<?php

namespace E2S\Endomondo\Api;

use Fabulator\Endomondo\EndomondoApi;

final class WorkoutRestApi implements WorkoutApi
{
    /** @var EndomondoApi */
    private $api;

    /** @var \Closure */
    private $login;

    /**
     * @param EndomondoApi $api
     * @param Credentials $credentials
     */
    public function __construct(EndomondoApi $api, Credentials $credentials)
    {
        $this->api = $api;
        $this->login = function () use ($credentials) {
            if (!$this->api->getUserId()) {
                $this->api->login($credentials->user(), $credentials->password());
            }
        };
    }

    /**
     * @inheritdoc
     */
    public function workouts(Filter $filter = null, int $limit = null, int $offset = null): array
    {
        $this->login();

        $filter = $filter ?: new Filter();
        $limit = $limit ?: 250;
        $offset = $offset ?: 0;

        $params = $filter->toQueryParams();
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $result = $this->api->get('workouts/history', $params);

        $workouts = [];
        foreach ($result['data'] as $workout) {
            $workouts[] = new Workout(
                new WorkoutId((int)$workout['id']),
                date_create($workout['start_time']),
                Sport::parse($workout['sport'])
            );
        }

        return $workouts;
    }

    /**
     * @inheritdoc
     */
    public function export(WorkoutId $id, Format $format = null)
    {
        $this->login();

        $format = $format ?: Format::gpx();
        $endpoint = sprintf(
            'rest/v1/users/%d/workouts/%d/export?format=%s',
            $this->api->getUserId(),
            (string)$id,
            (string)$format
        );
        $response = $this->api->send('GET', $endpoint);

        return new WorkoutFile($id, $format, $response->getBody()->getContents());
    }

    private function login()
    {
        call_user_func($this->login);
    }
}
