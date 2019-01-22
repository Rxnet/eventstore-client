<?php

declare(strict_types=1);

namespace Rxnet\EventStore\Exception;

use Throwable;

class NotMasterException extends \Exception
{
    protected $masterIp;
    protected $masterPort;

    public function __construct($ip, $port, Throwable $previous = null)
    {
        $this->masterIp = $ip;
        $this->masterPort = $port;
        parent::__construct("Not on master, you should connect to {$ip}:{$port} not here", 2, $previous);
    }

    public function getMasterIp()
    {
        return $this->masterIp;
    }

    public function getMasterPort()
    {
        return $this->masterPort;
    }
}
