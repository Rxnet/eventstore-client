<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: ClientMessageDtos.proto

namespace Rxnet\EventStore\Data;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>Rxnet.EventStore.Data.PersistentSubscriptionNakEvents</code>
 */
class PersistentSubscriptionNakEvents extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string subscription_id = 1;</code>
     */
    private $subscription_id = '';
    /**
     * Generated from protobuf field <code>repeated bytes processed_event_ids = 2;</code>
     */
    private $processed_event_ids;
    /**
     * Generated from protobuf field <code>string message = 3;</code>
     */
    private $message = '';
    /**
     * Generated from protobuf field <code>.Rxnet.EventStore.Data.PersistentSubscriptionNakEvents.NakAction action = 4;</code>
     */
    private $action = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $subscription_id
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $processed_event_ids
     *     @type string $message
     *     @type int $action
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\ClientMessageDtos::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string subscription_id = 1;</code>
     * @return string
     */
    public function getSubscriptionId()
    {
        return $this->subscription_id;
    }

    /**
     * Generated from protobuf field <code>string subscription_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setSubscriptionId($var)
    {
        GPBUtil::checkString($var, True);
        $this->subscription_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated bytes processed_event_ids = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getProcessedEventIds()
    {
        return $this->processed_event_ids;
    }

    /**
     * Generated from protobuf field <code>repeated bytes processed_event_ids = 2;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setProcessedEventIds($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::BYTES);
        $this->processed_event_ids = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string message = 3;</code>
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Generated from protobuf field <code>string message = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setMessage($var)
    {
        GPBUtil::checkString($var, True);
        $this->message = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.Rxnet.EventStore.Data.PersistentSubscriptionNakEvents.NakAction action = 4;</code>
     * @return int
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Generated from protobuf field <code>.Rxnet.EventStore.Data.PersistentSubscriptionNakEvents.NakAction action = 4;</code>
     * @param int $var
     * @return $this
     */
    public function setAction($var)
    {
        GPBUtil::checkEnum($var, \Rxnet\EventStore\Data\PersistentSubscriptionNakEvents_NakAction::class);
        $this->action = $var;

        return $this;
    }

}

