<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: ClientMessageDtos.proto

namespace Rxnet\EventStore\Data;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Protobuf type <code>Rxnet.EventStore.Data.PersistentSubscriptionConfirmation</code>
 */
class PersistentSubscriptionConfirmation extends \Google\Protobuf\Internal\Message
{
    /**
     * <code>int64 last_commit_position = 1;</code>
     */
    private $last_commit_position = 0;
    /**
     * <code>string subscription_id = 2;</code>
     */
    private $subscription_id = '';
    /**
     * <code>int32 last_event_number = 3;</code>
     */
    private $last_event_number = 0;

    public function __construct() {
        \GPBMetadata\ClientMessageDtos::initOnce();
        parent::__construct();
    }

    /**
     * <code>int64 last_commit_position = 1;</code>
     */
    public function getLastCommitPosition()
    {
        return $this->last_commit_position;
    }

    /**
     * <code>int64 last_commit_position = 1;</code>
     */
    public function setLastCommitPosition($var)
    {
        GPBUtil::checkInt64($var);
        $this->last_commit_position = $var;
    }

    /**
     * <code>string subscription_id = 2;</code>
     */
    public function getSubscriptionId()
    {
        return $this->subscription_id;
    }

    /**
     * <code>string subscription_id = 2;</code>
     */
    public function setSubscriptionId($var)
    {
        GPBUtil::checkString($var, True);
        $this->subscription_id = $var;
    }

    /**
     * <code>int32 last_event_number = 3;</code>
     */
    public function getLastEventNumber()
    {
        return $this->last_event_number;
    }

    /**
     * <code>int32 last_event_number = 3;</code>
     */
    public function setLastEventNumber($var)
    {
        GPBUtil::checkInt32($var);
        $this->last_event_number = $var;
    }

}

