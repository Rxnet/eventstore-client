<?php
namespace Rxnet\EventStore\Communication\Type;

use Rxnet\EventStore\Communication\Communicable;
use Rxnet\EventStore\Message\MessageType;
use Rxnet\EventStore\Message\SocketMessage;

/**
 * Class Pong
 *
 * @package Madkom\EventStore\Client\Domain\Socket\Communication\Type
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class PongHandler implements Communicable
{

	/**
	 * @inheritdoc
	 */
	public function handle(MessageType $messageType, $correlationID, $data)
	{
		return new SocketMessage($messageType, $correlationID);
	}

}