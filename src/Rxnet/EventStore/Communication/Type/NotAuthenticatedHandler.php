<?php declare(strict_types=1);

namespace Rxnet\EventStore\Communication\Type;

use Rxnet\EventStore\Communication\Communicable;
use Rxnet\EventStore\EventStoreHandlerException;
use Rxnet\EventStore\Message\MessageType;

class NotAuthenticatedHandler implements Communicable
{

    /**
     * @inheritDoc
     */
    public function handle(MessageType $messageType, $correlationID, $data)
    {
        throw new EventStoreHandlerException("Not Authenticated: " . $data);
    }
}
