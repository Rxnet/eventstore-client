<?php
namespace Rxnet\EventStore\Communication\Type;

use Rxnet\EventStore\Communication\Communicable;
use Rxnet\EventStore\Data\NotHandled;
use Rxnet\EventStore\Data\NotHandled\MasterInfo;
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
            $additional_info = $dataObject->getAdditionalInfo();
            $dataObject = new MasterInfo();
            $dataObject->mergeFromString($additional_info);
        }

        return new SocketMessage($messageType, $correlationID, $dataObject);
    }

}
