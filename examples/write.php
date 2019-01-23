<?php

use EventLoop\EventLoop;
use Rx\Observer\CallbackObserver;
use Rxnet\EventStore\Data\WriteEventsCompleted;
use Rxnet\EventStore\Event\JsonEvent;

require __DIR__ . '/../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\EventStore();

$eventStore->connect()
    ->subscribe(function () use ($eventStore) {
        echo 'connected'.PHP_EOL;
        \Rx\Observable::interval(10)
            ->flatMap(
                function ($i) use ($eventStore) {
                    echo 'write :'.PHP_EOL;
                    return $eventStore->write('domain-test.fr', [
                        new JsonEvent('/foo/bar', ['i' => $i]),
                        new JsonEvent('/foo/pub', ['i' => $i]),
                    ]);
                }
            )->subscribe(
                new CallbackObserver(
                    function (WriteEventsCompleted $eventsCompleted) {
                        echo "Last event number {$eventsCompleted->getLastEventNumber()} on commit position {$eventsCompleted->getCommitPosition()}".PHP_EOL;
                    }
                )
            );
    });

EventLoop::getLoop()->run();
