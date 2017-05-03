<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: ClientMessageDtos.proto

namespace Rxnet\EventStore\Data;

/**
 * Protobuf enum <code>Rxnet.EventStore.Data.OperationResult</code>
 */
class OperationResult
{
    /**
     * <code>Success = 0;</code>
     */
    const Success = 0;
    /**
     * <code>PrepareTimeout = 1;</code>
     */
    const PrepareTimeout = 1;
    /**
     * <code>CommitTimeout = 2;</code>
     */
    const CommitTimeout = 2;
    /**
     * <code>ForwardTimeout = 3;</code>
     */
    const ForwardTimeout = 3;
    /**
     * <code>WrongExpectedVersion = 4;</code>
     */
    const WrongExpectedVersion = 4;
    /**
     * <code>StreamDeleted = 5;</code>
     */
    const StreamDeleted = 5;
    /**
     * <code>InvalidTransaction = 6;</code>
     */
    const InvalidTransaction = 6;
    /**
     * <code>AccessDenied = 7;</code>
     */
    const AccessDenied = 7;
}

