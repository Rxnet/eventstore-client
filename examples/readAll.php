<?php

use EventLoop\EventLoop;

require __DIR__.'/../vendor/autoload.php';


$eventStore = new \Rxnet\EventStore\EventStore();
$eventStore->connect()
    ->subscribe(function() use ($eventStore) {
        echo "connected \n";
        $eventStore->readEventsForward('domain-test.fr')
            ->subscribe(function (\Rxnet\EventStore\EventRecord $record) {
                echo "received {$record->getId()}  {$record->getNumber()}@{$record->getStreamId()} {$record->getType()} created at {$record->getCreated()->format('c')}\n";
            });
    }, function (\Exception $e) {
        echo $e->getMessage();
    });

EventLoop::getLoop()->run();