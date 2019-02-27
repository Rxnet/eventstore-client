<?php

declare(strict_types=1);

/*
 * This file is part of the RxNET project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rxnet\EventStore\Event;

use Rxnet\EventStore\Helper\Json;

final class JsonEvent extends BaseEvent
{
    const CONTENT_TYPE = 1;

    public function __construct(
        string $type,
        array $data,
        array $metadata = [],
        string $id = null
    ) {
        $data = Json::safeEncode($data);
        $metadata = Json::safeEncode($metadata);
        parent::__construct($type, $data, $metadata, $id);
    }
}
