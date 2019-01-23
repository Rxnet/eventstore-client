<?php

use EventLoop\EventLoop;

require __DIR__ . '/../vendor/autoload.php';

$errorCallback = function (\Throwable $e) {
    echo $e->getMessage().PHP_EOL;
};

$stopCallback = function () {
    EventLoop::getLoop()->stop();
};

$eventStore = new \Rxnet\EventStore\EventStore();
$eventStore->connect()
    ->subscribe(
        function () use ($errorCallback, $stopCallback, $eventStore) {
            echo "connected".PHP_EOL;
            $eventStore->readEventsForward('domain-test.fr')
                ->subscribe(
                    function (\Rxnet\EventStore\EventRecord $record) {
                        echo "received {$record->getId()} {$record->getNumber()}@{$record->getStreamId()} {$record->getType()} created at {$record->getCreated()->format('c')}".PHP_EOL;
                    },
                    $errorCallback,
                    $stopCallback
                );
        },
        $errorCallback,
        $stopCallback
    );

EventLoop::getLoop()->run();
