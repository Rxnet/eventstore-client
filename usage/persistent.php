<?php
use Rxnet\EventStore\AcknowledgeableEventRecord;

require '../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\EventStore();
\Rxnet\await($eventStore->connect());

$eventStore->persistentSubscription('domain-test.fr', 'journal', 10)
    ->flatMap(function (AcknowledgeableEventRecord $record) {
        echo "received {$record->getId()}  {$record->getNumber()}@{$record->getStreamId()} {$record->getType()}\n";

        return $record->ack();
        //$record->nack($record::NACK_ACTION_PARK, 'oops');
    })
    ->subscribeCallback(null, function (\Exception $e) {
        echo $e->getMessage();
    });

\EventLoop\EventLoop::getLoop()->run();
