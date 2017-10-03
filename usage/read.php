<?php
use EventLoop\EventLoop;

require __DIR__ . '/../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\EventStore();
\Rxnet\await($eventStore->connect());

/*
$eventStore->readEvent('domain-test-1.fr', \Rxnet\EventStore\EventStore::POSITION_END)
    ->subscribeCallback(function() {
        var_dump(func_get_args());
    });
*/
$eventStore->catchUpSubscription('domain-test-1.fr', \Rxnet\EventStore\EventStore::POSITION_END)
    ->subscribeCallback(function (\Rxnet\EventStore\EventRecord $record) {
        //var_dump(func_get_args());
        //gc_collect_cycles();
        $memory = memory_get_usage(true) / 1024 / 1024;
        echo "received {$record->getId()}  {$record->getNumber()}@{$record->getStreamId()} {$record->getType()} created at {$record->getCreated()->format('c')} {$memory}Mb \n";
    }, function (\Exception $e) {
        echo $e->getMessage();
    });

EventLoop::getLoop()->run();
