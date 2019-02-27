<?php

use EventLoop\EventLoop;

require __DIR__ . '/../vendor/autoload.php';

$errorCallback = function (\Throwable $e) {
    var_dump($e);
    EventLoop::getLoop()->stop();
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
                    function (\Rxnet\EventStore\Record\EventRecord $record) {
                        var_dump(get_class($record));
                        echo "received {$record->getId()} {$record->getNumber()}@{$record->getStreamId()} {$record->getType()} created at {$record->getCreated()->format('c')}".PHP_EOL;
                        var_dump($record->getData());
                    },
                    $errorCallback,
                    $stopCallback
                );
        },
        $errorCallback,
        $stopCallback
    );

EventLoop::getLoop()->run();
