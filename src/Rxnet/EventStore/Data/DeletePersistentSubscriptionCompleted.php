<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: ClientMessageDtos.proto

namespace Rxnet\EventStore\Data;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Protobuf type <code>Rxnet.EventStore.Data.DeletePersistentSubscriptionCompleted</code>
 */
class DeletePersistentSubscriptionCompleted extends \Google\Protobuf\Internal\Message
{
    /**
     * <code>.Rxnet.EventStore.Data.DeletePersistentSubscriptionCompleted.DeletePersistentSubscriptionResult result = 1;</code>
     */
    private $result = 0;
    /**
     * <code>string reason = 2;</code>
     */
    private $reason = '';

    public function __construct() {
        \GPBMetadata\ClientMessageDtos::initOnce();
        parent::__construct();
    }

    /**
     * <code>.Rxnet.EventStore.Data.DeletePersistentSubscriptionCompleted.DeletePersistentSubscriptionResult result = 1;</code>
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * <code>.Rxnet.EventStore.Data.DeletePersistentSubscriptionCompleted.DeletePersistentSubscriptionResult result = 1;</code>
     */
    public function setResult($var)
    {
        GPBUtil::checkEnum($var, \Rxnet\EventStore\Data\DeletePersistentSubscriptionCompleted_DeletePersistentSubscriptionResult::class);
        $this->result = $var;
    }

    /**
     * <code>string reason = 2;</code>
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * <code>string reason = 2;</code>
     */
    public function setReason($var)
    {
        GPBUtil::checkString($var, True);
        $this->reason = $var;
    }

}

