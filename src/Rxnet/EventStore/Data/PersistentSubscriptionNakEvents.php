<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: ClientMessageDtos.proto

namespace Rxnet\EventStore\Data;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Protobuf type <code>Rxnet.EventStore.Data.PersistentSubscriptionNakEvents</code>
 */
class PersistentSubscriptionNakEvents extends \Google\Protobuf\Internal\Message
{
    /**
     * <code>string subscription_id = 1;</code>
     */
    private $subscription_id = '';
    /**
     * <code>repeated bytes processed_event_ids = 2;</code>
     */
    private $processed_event_ids;
    /**
     * <code>string message = 3;</code>
     */
    private $message = '';
    /**
     * <code>.Rxnet.EventStore.Data.PersistentSubscriptionNakEvents.NakAction action = 4;</code>
     */
    private $action = 0;

    public function __construct() {
        \GPBMetadata\ClientMessageDtos::initOnce();
        parent::__construct();
    }

    /**
     * <code>string subscription_id = 1;</code>
     */
    public function getSubscriptionId()
    {
        return $this->subscription_id;
    }

    /**
     * <code>string subscription_id = 1;</code>
     */
    public function setSubscriptionId($var)
    {
        GPBUtil::checkString($var, True);
        $this->subscription_id = $var;
    }

    /**
     * <code>repeated bytes processed_event_ids = 2;</code>
     */
    public function getProcessedEventIds()
    {
        return $this->processed_event_ids;
    }

    /**
     * <code>repeated bytes processed_event_ids = 2;</code>
     */
    public function setProcessedEventIds(&$var)
    {
        GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::BYTES);
        $this->processed_event_ids = $var;
    }

    /**
     * <code>string message = 3;</code>
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * <code>string message = 3;</code>
     */
    public function setMessage($var)
    {
        GPBUtil::checkString($var, True);
        $this->message = $var;
    }

    /**
     * <code>.Rxnet.EventStore.Data.PersistentSubscriptionNakEvents.NakAction action = 4;</code>
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * <code>.Rxnet.EventStore.Data.PersistentSubscriptionNakEvents.NakAction action = 4;</code>
     */
    public function setAction($var)
    {
        GPBUtil::checkEnum($var, \Rxnet\EventStore\Data\PersistentSubscriptionNakEvents_NakAction::class);
        $this->action = $var;
    }

}
