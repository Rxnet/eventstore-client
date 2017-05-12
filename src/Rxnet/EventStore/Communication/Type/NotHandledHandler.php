<?php
namespace Rxnet\EventStore\Communication\Type;

use Rxnet\EventStore\Communication\Communicable;
use Rxnet\EventStore\Data\NotHandled;
use Rxnet\EventStore\Data\NotHandled_MasterInfo;
use Rxnet\EventStore\Data\SubscriptionDropped;
use Rxnet\EventStore\Message\MessageType;
use Rxnet\EventStore\Message\SocketMessage;
/**
 * Class SubscriptionDroppedHandler
 *
 * @package Madkom\EventStore\Client\Domain\Socket\Communication\Type
 * @author Jur Jean
 */
class NotHandledHandler implements Communicable
{

    /**
     * @inheritDoc
     */
    public function handle(MessageType $messageType, $correlationID, $data)
    {
        $dataObject = new NotHandled();
        $dataObject->mergeFromString($data);
        if($dataObject->getReason() == 2) {
            $dataObject = new NotHandled_MasterInfo();
            $dataObject->mergeFromString($data);
        }

        return new SocketMessage($messageType, $correlationID, $dataObject);
    }

}