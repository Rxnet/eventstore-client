<?php
use EventLoop\EventLoop;

require '../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\EventStore();
\Rxnet\await($eventStore->connect());


$eventStore->catchUpSubscription('domain-test-1.fr', 0)
    ->subscribeCallback(function (\Rxnet\EventStore\EventRecord $record) {
        gc_collect_cycles();
        $memory = memory_get_usage(true) / 1024 / 1024;
        echo "received {$record->getId()}  {$record->getNumber()}@{$record->getStreamId()} {$record->getType()} created at {$record->getCreated()->format('c')} {$memory}Mb \n";
    }, function (\Exception $e) {
        echo $e->getMessage();
    });

EventLoop::getLoop()->run();