<?php

declare(strict_types=1);

/*
 * This file is part of the RxNET project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rxnet\EventStore\Communication;

use Rxnet\EventStore\Exception\EventStoreHandlerException;
use Rxnet\EventStore\Message\MessageType;

final class CommunicationFactory
{
    /**
     * @throws EventStoreHandlerException
     */
    public function create(MessageType $messageType): Communicable
    {
        $communicable = null;

        switch ($messageType->getType()) {

            case MessageType::PONG:
                $communicable = new Type\PongHandler();
                break;
            case MessageType::HEARTBEAT_REQUEST_COMMAND:
                $communicable = new Type\HeartBeatRequestHandler();
                break;
            case MessageType::READ_EVENT_COMPLETED:
                $communicable = new Type\ReadEventCompletedHandler();
                break;
            case MessageType::READ_ALL_EVENTS_BACKWARD_COMPLETED:
            case MessageType::READ_ALL_EVENTS_FORWARD_COMPLETED:
                $communicable = new Type\ReadAllEventsCompletedHandler();
                break;
            case MessageType::READ_STREAM_EVENTS_BACKWARD_COMPLETED:
                $communicable = new Type\ReadStreamEventsCompletedHandler();
                break;
            case MessageType::READ_STREAM_EVENTS_FORWARD_COMPLETED:
                $communicable = new Type\ReadStreamEventsCompletedHandler();
                break;
            case MessageType::SUBSCRIPTION_CONFIRMATION:
                $communicable = new Type\SubscriptionConfirmationHandler();
                break;
            case MessageType::SUBSCRIPTION_DROPPED:
                $communicable = new Type\SubscriptionDroppedHandler();
                break;
            case MessageType::NOT_HANDLED:
                $communicable = new Type\NotHandledHandler();
                break;
            case MessageType::PERSISTENT_SUBSCRIPTION_CONFIRMATION:
                $communicable = new Type\PersistentSubscriptionConfirmationHandler();
                break;
            case MessageType::PERSISTENT_SUBSCRIPTION_STREAM_EVENT_APPEARED:
                $communicable = new Type\PersistentSubscriptionStreamEventAppearedHandler();
                break;
            case MessageType::BAD_REQUEST:
                $communicable = new Type\BadRequestHandler();
                break;
            case MessageType::WRITE_EVENTS_COMPLETED:
                $communicable = new Type\WriteEventsCompletedHandler();
                break;
            case MessageType::STREAM_EVENT_APPEARED:
                $communicable = new Type\StreamEventAppearedHandler();
                break;
            case MessageType::NOT_AUTHENTICATED:
                $communicable = new Type\NotAuthenticatedHandler();
                break;
            case MessageType::TRANSACTION_START_COMPLETED:
                $communicable = new Type\TransactionStartCompletedHandler();
                break;
            case MessageType::TRANSACTION_WRITE_COMPLETED:
                $communicable = new Type\TransactionWriteCompletedHandler();
                break;
            case MessageType::TRANSACTION_COMMIT_COMPLETED:
                $communicable = new Type\TransactionCommitCompletedHandler();
                break;
            default:
                throw new EventStoreHandlerException('Unsupported message type ' . $messageType->getType());
        }

        return $communicable;
    }
}
