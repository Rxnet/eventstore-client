<?php declare(strict_types=1);

namespace Rxnet\EventStore\Communication\Type;

use Rxnet\EventStore\Communication\Communicable;
use Rxnet\EventStore\Exception\EventStoreHandlerException;
use Rxnet\EventStore\Message\MessageType;

/**
 * Class BadRequest
 * @package Madkom\EventStore\Client\Domain\Socket\Communication\Type
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class BadRequestHandler implements Communicable
{

    /**
     * @inheritDoc
     */
    public function handle(MessageType $messageType, $correlationID, $data)
    {
        throw new EventStoreHandlerException("Bad Request: " . $data);
    }
}
