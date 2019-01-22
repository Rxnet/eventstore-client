<?php declare(strict_types=1);

namespace Rxnet\EventStore\Message;

/**
 * Class Credentials
 * @package Madkom\EventStore\Client\Domain\Socket\Message
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Credentials
{

    /** @var  string */
    private $password;

    /** @var  string */
    private $username;

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
