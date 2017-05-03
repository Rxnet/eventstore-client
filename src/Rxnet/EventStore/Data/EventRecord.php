<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: ClientMessageDtos.proto

namespace Rxnet\EventStore\Data;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Protobuf type <code>Rxnet.EventStore.Data.EventRecord</code>
 */
class EventRecord extends \Google\Protobuf\Internal\Message
{
    /**
     * <code>string event_stream_id = 1;</code>
     */
    private $event_stream_id = '';
    /**
     * <code>int32 event_number = 2;</code>
     */
    private $event_number = 0;
    /**
     * <code>bytes event_id = 3;</code>
     */
    private $event_id = '';
    /**
     * <code>string event_type = 4;</code>
     */
    private $event_type = '';
    /**
     * <code>int32 data_content_type = 5;</code>
     */
    private $data_content_type = 0;
    /**
     * <code>int32 metadata_content_type = 6;</code>
     */
    private $metadata_content_type = 0;
    /**
     * <code>bytes data = 7;</code>
     */
    private $data = '';
    /**
     * <code>bytes metadata = 8;</code>
     */
    private $metadata = '';
    /**
     * <code>int64 created = 9;</code>
     */
    private $created = 0;
    /**
     * <code>int64 created_epoch = 10;</code>
     */
    private $created_epoch = 0;

    public function __construct() {
        \GPBMetadata\ClientMessageDtos::initOnce();
        parent::__construct();
    }

    /**
     * <code>string event_stream_id = 1;</code>
     */
    public function getEventStreamId()
    {
        return $this->event_stream_id;
    }

    /**
     * <code>string event_stream_id = 1;</code>
     */
    public function setEventStreamId($var)
    {
        GPBUtil::checkString($var, True);
        $this->event_stream_id = $var;
    }

    /**
     * <code>int32 event_number = 2;</code>
     */
    public function getEventNumber()
    {
        return $this->event_number;
    }

    /**
     * <code>int32 event_number = 2;</code>
     */
    public function setEventNumber($var)
    {
        GPBUtil::checkInt32($var);
        $this->event_number = $var;
    }

    /**
     * <code>bytes event_id = 3;</code>
     */
    public function getEventId()
    {
        return $this->event_id;
    }

    /**
     * <code>bytes event_id = 3;</code>
     */
    public function setEventId($var)
    {
        GPBUtil::checkString($var, False);
        $this->event_id = $var;
    }

    /**
     * <code>string event_type = 4;</code>
     */
    public function getEventType()
    {
        return $this->event_type;
    }

    /**
     * <code>string event_type = 4;</code>
     */
    public function setEventType($var)
    {
        GPBUtil::checkString($var, True);
        $this->event_type = $var;
    }

    /**
     * <code>int32 data_content_type = 5;</code>
     */
    public function getDataContentType()
    {
        return $this->data_content_type;
    }

    /**
     * <code>int32 data_content_type = 5;</code>
     */
    public function setDataContentType($var)
    {
        GPBUtil::checkInt32($var);
        $this->data_content_type = $var;
    }

    /**
     * <code>int32 metadata_content_type = 6;</code>
     */
    public function getMetadataContentType()
    {
        return $this->metadata_content_type;
    }

    /**
     * <code>int32 metadata_content_type = 6;</code>
     */
    public function setMetadataContentType($var)
    {
        GPBUtil::checkInt32($var);
        $this->metadata_content_type = $var;
    }

    /**
     * <code>bytes data = 7;</code>
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * <code>bytes data = 7;</code>
     */
    public function setData($var)
    {
        GPBUtil::checkString($var, False);
        $this->data = $var;
    }

    /**
     * <code>bytes metadata = 8;</code>
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * <code>bytes metadata = 8;</code>
     */
    public function setMetadata($var)
    {
        GPBUtil::checkString($var, False);
        $this->metadata = $var;
    }

    /**
     * <code>int64 created = 9;</code>
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * <code>int64 created = 9;</code>
     */
    public function setCreated($var)
    {
        GPBUtil::checkInt64($var);
        $this->created = $var;
    }

    /**
     * <code>int64 created_epoch = 10;</code>
     */
    public function getCreatedEpoch()
    {
        return $this->created_epoch;
    }

    /**
     * <code>int64 created_epoch = 10;</code>
     */
    public function setCreatedEpoch($var)
    {
        GPBUtil::checkInt64($var);
        $this->created_epoch = $var;
    }

}

