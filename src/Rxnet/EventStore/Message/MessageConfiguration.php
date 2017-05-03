<?php

namespace Rxnet\EventStore\Message;


/**
 * Class MessageConfiguration
 * @package Madkom\EventStore\Client\Domain\Socket\Message
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class MessageConfiguration
{

//    Message content

    /** Byte length of INT in 32 bits */
    const INT_32_LENGTH         = 4;

    /** Byte length of correlation ID */
    const CORRELATION_ID_LENGTH = 16;

    /** Byte length of header [CORRELATION_ID_LENGTH + COMMAND_LENGTH + FLAG_LENGTH] */
    const HEADER_LENGTH = 18;

    /** @var int Byte offset of Command | MESSAGE_TYPE_OFFSET == INT_32_LENGTH */
    const MESSAGE_TYPE_OFFSET = 4;

    /** @var int Byte offset of Flag | FLAG_OFFSET = MESSAGE_TYPE_OFFSET + 1 */
    const FLAG_OFFSET = 5;

    /** @var int  Byte offset of correlation id | CORRELATION_ID_OFFSET = FLAG_OFFSET + 1 */
    const CORRELATION_ID_OFFSET = 6;

    /** @var  int Byte offset of data | DATA_OFFSET = CORRELATION_ID_OFFSET + CORRELATION_ID_LENGTH */
    const DATA_OFFSET = 22;

//    Flags

    const FLAGS_NONE = 0x00;

    const FLAG_AUTHORIZATION = 0x01;

    private function __construct(){}

}