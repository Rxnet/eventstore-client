<?php
namespace Rxnet\EventStore\NewEvent;


interface NewEventInterface
{
    public function setData($data);

    public function setMetaData($meta);

    public function setId($id);

    public function setType($type);

    public function getMessage();

    public function getType();
    public function getData();
    public function getMetaData();
}