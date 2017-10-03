<?php
use Rxnet\EventStore\AcknowledgeableEventRecord;

require __DIR__ . '/../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\EventStore();
\Rxnet\await($eventStore->connect());

$eventStore->persistentSubscription('crypto', 'test')
    ->flatMap(function (AcknowledgeableEventRecord $record) {
        echo "received {$record->getId()}  {$record->getNumber()}@{$record->getStreamId()} {$record->getType()}\n";
        var_dump($record->getData());
        return $record->ack();
        //return $record->nack($record::NACK_ACTION_PARK, 'oops');
    })
    ->subscribeCallback(null, function (\Exception $e) {
        echo $e->getMessage();
    });

\EventLoop\EventLoop::getLoop()->run();
