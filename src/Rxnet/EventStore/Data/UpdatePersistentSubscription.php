<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: ClientMessageDtos.proto

namespace Rxnet\EventStore\Data;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Protobuf type <code>Rxnet.EventStore.Data.UpdatePersistentSubscription</code>
 */
class UpdatePersistentSubscription extends \Google\Protobuf\Internal\Message
{
    /**
     * <code>string subscription_group_name = 1;</code>
     */
    private $subscription_group_name = '';
    /**
     * <code>string event_stream_id = 2;</code>
     */
    private $event_stream_id = '';
    /**
     * <code>bool resolve_link_tos = 3;</code>
     */
    private $resolve_link_tos = false;
    /**
     * <code>int32 start_from = 4;</code>
     */
    private $start_from = 0;
    /**
     * <code>int32 message_timeout_milliseconds = 5;</code>
     */
    private $message_timeout_milliseconds = 0;
    /**
     * <code>bool record_statistics = 6;</code>
     */
    private $record_statistics = false;
    /**
     * <code>int32 live_buffer_size = 7;</code>
     */
    private $live_buffer_size = 0;
    /**
     * <code>int32 read_batch_size = 8;</code>
     */
    private $read_batch_size = 0;
    /**
     * <code>int32 buffer_size = 9;</code>
     */
    private $buffer_size = 0;
    /**
     * <code>int32 max_retry_count = 10;</code>
     */
    private $max_retry_count = 0;
    /**
     * <code>bool prefer_round_robin = 11;</code>
     */
    private $prefer_round_robin = false;
    /**
     * <code>int32 checkpoint_after_time = 12;</code>
     */
    private $checkpoint_after_time = 0;
    /**
     * <code>int32 checkpoint_max_count = 13;</code>
     */
    private $checkpoint_max_count = 0;
    /**
     * <code>int32 checkpoint_min_count = 14;</code>
     */
    private $checkpoint_min_count = 0;
    /**
     * <code>int32 subscriber_max_count = 15;</code>
     */
    private $subscriber_max_count = 0;
    /**
     * <code>string named_consumer_strategy = 16;</code>
     */
    private $named_consumer_strategy = '';

    public function __construct() {
        \GPBMetadata\ClientMessageDtos::initOnce();
        parent::__construct();
    }

    /**
     * <code>string subscription_group_name = 1;</code>
     */
    public function getSubscriptionGroupName()
    {
        return $this->subscription_group_name;
    }

    /**
     * <code>string subscription_group_name = 1;</code>
     */
    public function setSubscriptionGroupName($var)
    {
        GPBUtil::checkString($var, True);
        $this->subscription_group_name = $var;
    }

    /**
     * <code>string event_stream_id = 2;</code>
     */
    public function getEventStreamId()
    {
        return $this->event_stream_id;
    }

    /**
     * <code>string event_stream_id = 2;</code>
     */
    public function setEventStreamId($var)
    {
        GPBUtil::checkString($var, True);
        $this->event_stream_id = $var;
    }

    /**
     * <code>bool resolve_link_tos = 3;</code>
     */
    public function getResolveLinkTos()
    {
        return $this->resolve_link_tos;
    }

    /**
     * <code>bool resolve_link_tos = 3;</code>
     */
    public function setResolveLinkTos($var)
    {
        GPBUtil::checkBool($var);
        $this->resolve_link_tos = $var;
    }

    /**
     * <code>int32 start_from = 4;</code>
     */
    public function getStartFrom()
    {
        return $this->start_from;
    }

    /**
     * <code>int32 start_from = 4;</code>
     */
    public function setStartFrom($var)
    {
        GPBUtil::checkInt32($var);
        $this->start_from = $var;
    }

    /**
     * <code>int32 message_timeout_milliseconds = 5;</code>
     */
    public function getMessageTimeoutMilliseconds()
    {
        return $this->message_timeout_milliseconds;
    }

    /**
     * <code>int32 message_timeout_milliseconds = 5;</code>
     */
    public function setMessageTimeoutMilliseconds($var)
    {
        GPBUtil::checkInt32($var);
        $this->message_timeout_milliseconds = $var;
    }

    /**
     * <code>bool record_statistics = 6;</code>
     */
    public function getRecordStatistics()
    {
        return $this->record_statistics;
    }

    /**
     * <code>bool record_statistics = 6;</code>
     */
    public function setRecordStatistics($var)
    {
        GPBUtil::checkBool($var);
        $this->record_statistics = $var;
    }

    /**
     * <code>int32 live_buffer_size = 7;</code>
     */
    public function getLiveBufferSize()
    {
        return $this->live_buffer_size;
    }

    /**
     * <code>int32 live_buffer_size = 7;</code>
     */
    public function setLiveBufferSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->live_buffer_size = $var;
    }

    /**
     * <code>int32 read_batch_size = 8;</code>
     */
    public function getReadBatchSize()
    {
        return $this->read_batch_size;
    }

    /**
     * <code>int32 read_batch_size = 8;</code>
     */
    public function setReadBatchSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->read_batch_size = $var;
    }

    /**
     * <code>int32 buffer_size = 9;</code>
     */
    public function getBufferSize()
    {
        return $this->buffer_size;
    }

    /**
     * <code>int32 buffer_size = 9;</code>
     */
    public function setBufferSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->buffer_size = $var;
    }

    /**
     * <code>int32 max_retry_count = 10;</code>
     */
    public function getMaxRetryCount()
    {
        return $this->max_retry_count;
    }

    /**
     * <code>int32 max_retry_count = 10;</code>
     */
    public function setMaxRetryCount($var)
    {
        GPBUtil::checkInt32($var);
        $this->max_retry_count = $var;
    }

    /**
     * <code>bool prefer_round_robin = 11;</code>
     */
    public function getPreferRoundRobin()
    {
        return $this->prefer_round_robin;
    }

    /**
     * <code>bool prefer_round_robin = 11;</code>
     */
    public function setPreferRoundRobin($var)
    {
        GPBUtil::checkBool($var);
        $this->prefer_round_robin = $var;
    }

    /**
     * <code>int32 checkpoint_after_time = 12;</code>
     */
    public function getCheckpointAfterTime()
    {
        return $this->checkpoint_after_time;
    }

    /**
     * <code>int32 checkpoint_after_time = 12;</code>
     */
    public function setCheckpointAfterTime($var)
    {
        GPBUtil::checkInt32($var);
        $this->checkpoint_after_time = $var;
    }

    /**
     * <code>int32 checkpoint_max_count = 13;</code>
     */
    public function getCheckpointMaxCount()
    {
        return $this->checkpoint_max_count;
    }

    /**
     * <code>int32 checkpoint_max_count = 13;</code>
     */
    public function setCheckpointMaxCount($var)
    {
        GPBUtil::checkInt32($var);
        $this->checkpoint_max_count = $var;
    }

    /**
     * <code>int32 checkpoint_min_count = 14;</code>
     */
    public function getCheckpointMinCount()
    {
        return $this->checkpoint_min_count;
    }

    /**
     * <code>int32 checkpoint_min_count = 14;</code>
     */
    public function setCheckpointMinCount($var)
    {
        GPBUtil::checkInt32($var);
        $this->checkpoint_min_count = $var;
    }

    /**
     * <code>int32 subscriber_max_count = 15;</code>
     */
    public function getSubscriberMaxCount()
    {
        return $this->subscriber_max_count;
    }

    /**
     * <code>int32 subscriber_max_count = 15;</code>
     */
    public function setSubscriberMaxCount($var)
    {
        GPBUtil::checkInt32($var);
        $this->subscriber_max_count = $var;
    }

    /**
     * <code>string named_consumer_strategy = 16;</code>
     */
    public function getNamedConsumerStrategy()
    {
        return $this->named_consumer_strategy;
    }

    /**
     * <code>string named_consumer_strategy = 16;</code>
     */
    public function setNamedConsumerStrategy($var)
    {
        GPBUtil::checkString($var, True);
        $this->named_consumer_strategy = $var;
    }

}

