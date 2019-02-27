<?php

declare(strict_types=1);

/*
 * This file is part of the RxNET project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rxnet\EventStore\Exception;

use Throwable;

final class NotMasterException extends \Exception
{
    protected $masterIp;
    protected $masterPort;

    public function __construct(string $ip, int $port, Throwable $previous = null)
    {
        $this->masterIp = $ip;
        $this->masterPort = $port;
        parent::__construct("Not on master, you should connect to {$ip}:{$port} not here", 2, $previous);
    }

    public function getMasterIp(): string
    {
        return $this->masterIp;
    }

    public function getMasterPort(): int
    {
        return $this->masterPort;
    }
}
