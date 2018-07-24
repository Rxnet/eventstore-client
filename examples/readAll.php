<?php

use EventLoop\EventLoop;

require __DIR__ . '/../vendor/autoload.php';
ini_set('memory_limit', '500M');

$eventStore = new \Rxnet\EventStore\EventStore();
$eventStore->connect()
    ->subscribe(
        function () use ($eventStore) {
            echo "connected \n";
            $eventStore->readEventsForward('domain-test.fr')
                ->subscribe(
                    function (\Rxnet\EventStore\EventRecord $record) {
                        echo "received {$record->getId()}  {$record->getNumber()}@{$record->getStreamId()} {$record->getType()} created at {$record->getCreated()->format('c')}\n";
                    },
                    function ( $e) {
                        echo $e->getMessage();
                    },
                    function () {
                        EventLoop::getLoop()->stop();
                    }
                );
        },
        function ($e) {
            echo $e->getMessage();
        },
        function () {
            EventLoop::getLoop()->stop();
        }
    );

EventLoop::getLoop()->run();