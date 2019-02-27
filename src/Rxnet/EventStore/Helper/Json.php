<?php

declare(strict_types=1);

/*
 * This file is part of the RxNET project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rxnet\EventStore\Helper;

use Rxnet\EventStore\Exception\JsonException;

final class Json
{
    /**
     * @throws JsonException
     */
    public static function safeEncode($value, int $options = 0, int $depth = 512): string
    {
        error_clear_last();
        $result = \json_encode($value, $options, $depth);
        if ($result === false) {
            throw JsonException::createFromPhpError();
        }
        return $result;
    }
}
