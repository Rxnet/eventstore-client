<?php

declare(strict_types=1);

namespace Rxnet\EventStore\Exception;

final class JsonException extends \Exception
{
    public static function createFromPhpError(): self
    {
        return new static(\json_last_error_msg(), \json_last_error());
    }
}
