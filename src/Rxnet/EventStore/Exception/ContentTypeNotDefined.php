<?php

namespace Rxnet\EventStore\Exception;

class ContentTypeNotDefined extends \Exception
{
    public function __construct(string $class)
    {
        parent::__construct(sprintf('The constant CONTENT_TYPE must be defined in %s class', $class));
    }
}
