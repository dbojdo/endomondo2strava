<?php

namespace E2S\Endomondo\Api;

final class Credentials
{
    /** @var string */
    private $user;

    /** @var string */
    private $password;

    public function __construct(string $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function user(): string
    {
        return $this->user;
    }

    public function password(): string
    {
        return $this->password;
    }
}