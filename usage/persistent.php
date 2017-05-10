<?php
require '../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\EventStore();
\Rxnet\await($eventStore->connect());

$eventStore->persistentSubscription('domain-test.fr', 'journal', 100)
    ->subscribeCallback(function (\Rxnet\EventStore\AcknowledgeableEventRecord $record) {
        //$metadata = json_decode($record->getMetadata(), true);
        echo "received {$record->getId()}  {$record->getNumber()}@{$record->getStreamId()} {$record->getType()}\n";

        $record->ack();
        //$record->nack($record::NACK_ACTION_PARK, 'oops');
    }, function (\Exception $e) {
        echo $e->getMessage();
    });

\EventLoop\EventLoop::getLoop()->run();
