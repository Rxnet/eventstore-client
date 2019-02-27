<?php

declare(strict_types=1);

/*
 * This file is part of the RxNET project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rxnet\EventStore\Communication\Type;

use Rxnet\EventStore\Communication\Communicable;
use Rxnet\EventStore\Data\NotHandled;
use Rxnet\EventStore\Data\NotHandled\MasterInfo;
use Rxnet\EventStore\Message\MessageType;
use Rxnet\EventStore\Message\SocketMessage;

final class NotHandledHandler implements Communicable
{
    public function handle(
        MessageType $messageType,
        string $correlationID,
        string $data
    ): SocketMessage {
        $dataObject = new NotHandled();
        $dataObject->mergeFromString($data);

        if ($dataObject->getReason() == 2) {
            $additional_info = $dataObject->getAdditionalInfo();
            $dataObject = new MasterInfo();
            $dataObject->mergeFromString($additional_info);
        }

        return new SocketMessage($messageType, $correlationID, $dataObject);
    }
}
