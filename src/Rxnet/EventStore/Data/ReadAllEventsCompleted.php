<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: ClientMessageDtos.proto

namespace Rxnet\EventStore\Data;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Protobuf type <code>Rxnet.EventStore.Data.ReadAllEventsCompleted</code>
 */
class ReadAllEventsCompleted extends \Google\Protobuf\Internal\Message
{
    /**
     * <code>int64 commit_position = 1;</code>
     */
    private $commit_position = 0;
    /**
     * <code>int64 prepare_position = 2;</code>
     */
    private $prepare_position = 0;
    /**
     * <code>repeated .Rxnet.EventStore.Data.ResolvedEvent events = 3;</code>
     */
    private $events;
    /**
     * <code>int64 next_commit_position = 4;</code>
     */
    private $next_commit_position = 0;
    /**
     * <code>int64 next_prepare_position = 5;</code>
     */
    private $next_prepare_position = 0;
    /**
     * <code>.Rxnet.EventStore.Data.ReadAllEventsCompleted.ReadAllResult result = 6;</code>
     */
    private $result = 0;
    /**
     * <code>string error = 7;</code>
     */
    private $error = '';

    public function __construct() {
        \GPBMetadata\ClientMessageDtos::initOnce();
        parent::__construct();
    }

    /**
     * <code>int64 commit_position = 1;</code>
     */
    public function getCommitPosition()
    {
        return $this->commit_position;
    }

    /**
     * <code>int64 commit_position = 1;</code>
     */
    public function setCommitPosition($var)
    {
        GPBUtil::checkInt64($var);
        $this->commit_position = $var;
    }

    /**
     * <code>int64 prepare_position = 2;</code>
     */
    public function getPreparePosition()
    {
        return $this->prepare_position;
    }

    /**
     * <code>int64 prepare_position = 2;</code>
     */
    public function setPreparePosition($var)
    {
        GPBUtil::checkInt64($var);
        $this->prepare_position = $var;
    }

    /**
     * <code>repeated .Rxnet.EventStore.Data.ResolvedEvent events = 3;</code>
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * <code>repeated .Rxnet.EventStore.Data.ResolvedEvent events = 3;</code>
     */
    public function setEvents(&$var)
    {
        GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Rxnet\EventStore\Data\ResolvedEvent::class);
        $this->events = $var;
    }

    /**
     * <code>int64 next_commit_position = 4;</code>
     */
    public function getNextCommitPosition()
    {
        return $this->next_commit_position;
    }

    /**
     * <code>int64 next_commit_position = 4;</code>
     */
    public function setNextCommitPosition($var)
    {
        GPBUtil::checkInt64($var);
        $this->next_commit_position = $var;
    }

    /**
     * <code>int64 next_prepare_position = 5;</code>
     */
    public function getNextPreparePosition()
    {
        return $this->next_prepare_position;
    }

    /**
     * <code>int64 next_prepare_position = 5;</code>
     */
    public function setNextPreparePosition($var)
    {
        GPBUtil::checkInt64($var);
        $this->next_prepare_position = $var;
    }

    /**
     * <code>.Rxnet.EventStore.Data.ReadAllEventsCompleted.ReadAllResult result = 6;</code>
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * <code>.Rxnet.EventStore.Data.ReadAllEventsCompleted.ReadAllResult result = 6;</code>
     */
    public function setResult($var)
    {
        GPBUtil::checkEnum($var, \Rxnet\EventStore\Data\ReadAllEventsCompleted_ReadAllResult::class);
        $this->result = $var;
    }

    /**
     * <code>string error = 7;</code>
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * <code>string error = 7;</code>
     */
    public function setError($var)
    {
        GPBUtil::checkString($var, True);
        $this->error = $var;
    }

}

