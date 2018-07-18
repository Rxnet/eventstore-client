<?php

use EventLoop\EventLoop;
use Rx\Observer\CallbackObserver;
use Rxnet\EventStore\Data\WriteEventsCompleted;
use Rxnet\EventStore\NewEvent\JsonEvent;

require __DIR__ . '/../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\EventStore();

$eventStore->connect()
    ->subscribe(function () use ($eventStore) {
        echo "connected \n";
        \Rx\Observable::interval(100)
            ->flatMap(
                function ($i) use ($eventStore) {
                    echo 'write : ';
                    $event = new JsonEvent('/truc/chose', ['i' => $i]);
                    return $eventStore->write('domain-test.fr', [$event]);
                }
            )->subscribe(
                new CallbackObserver(
                    function (WriteEventsCompleted $eventsCompleted) {
                        echo "Last event number {$eventsCompleted->getLastEventNumber()} on commit position {$eventsCompleted->getCommitPosition()} \n";
                    }
                )
            );
    });

EventLoop::getLoop()->run();