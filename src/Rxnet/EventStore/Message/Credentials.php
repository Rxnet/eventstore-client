<?php

declare(strict_types=1);

namespace Rxnet\EventStore\Message;

class Credentials
{
    private $password;

    private $username;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function fromDsn(string $dsn): self
    {
        $user = parse_url($dsn, PHP_URL_USER) ?? 'admin';
        $pass = parse_url($dsn, PHP_URL_PASS) ?? 'changeit';

        return new self($user, $pass);
    }
}
