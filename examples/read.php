<?php

use EventLoop\EventLoop;

require __DIR__.'/../vendor/autoload.php';


$eventStore = new \Rxnet\EventStore\EventStore();
$eventStore->connect()
    ->subscribe(function() use ($eventStore) {
        echo "connected".PHP_EOL;
        $eventStore->readEvent('domain-test.fr', 0)
            ->subscribe(function (\Rxnet\EventStore\Record\EventRecord $record) {
                echo "received {$record->getId()}  {$record->getNumber()}@{$record->getStreamId()} {$record->getType()} created at {$record->getCreated()->format('c')}".PHP_EOL;
            });
    }, function (\Exception $e) {
        echo $e->getMessage();
    });

EventLoop::getLoop()->run();
