<?php
use EventLoop\EventLoop;

require '../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\EventStore();
\Rxnet\await($eventStore->connect('online-10.4x.fr'));


$eventStore->catchUpSubscription('domain-test.fr', 0)
    ->subscribeCallback(function (\Rxnet\EventStore\EventRecord $record) {
        echo "received {$record->getId()}  {$record->getNumber()}@{$record->getStreamId()} {$record->getType()} created at {$record->getCreated()->format('c')}\n";
    }, function (\Exception $e) {
        echo $e->getMessage();
    });

EventLoop::getLoop()->run();