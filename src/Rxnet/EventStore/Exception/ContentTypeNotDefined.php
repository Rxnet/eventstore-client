<?php

declare(strict_types=1);

/*
 * This file is part of the RxNET project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rxnet\EventStore\Exception;

class ContentTypeNotDefined extends \Exception
{
    public function __construct(string $class)
    {
        parent::__construct(sprintf('The constant CONTENT_TYPE must be defined in %s class', $class));
    }
}
