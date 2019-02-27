<?php

declare(strict_types=1);

/*
 * This file is part of the RxNET project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rxnet\EventStore\Exception;

final class JsonException extends \Exception
{
    public static function createFromPhpError(): self
    {
        return new static(\json_last_error_msg(), \json_last_error());
    }
}
