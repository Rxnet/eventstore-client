Event Store Client
==================

Client for [event store](https://geteventstore.com/) TCP Api


## Usage
### Connect
```php
<?php

$eventStore = new \Rxnet\EventStore\EventStore();
$eventStore->connect('tcp://admin:changeit@localhost:1113');

$eventStore = new \Rxnet\EventStore\EventStore();
// Lazy way, you can use also subscribeCallback to something after commit
$eventStore = \Rxnet\await($eventStore->connect());
/* @var \Rxnet\EventStore\EventStore $eventStore */
echo "connected \n";
```

### Write
```php
<?php
// You can put as many event you want before commit or commit after each
$eventStore->appendToStream('category-test_stream_id')
    ->jsonEvent('event_type', ['data' => microtime()])
    ->jsonEvent('event_type2', ['data' => microtime()])
    ->jsonEvent('event_type3', ['data' => microtime()])
    ->commit()
    ->subscribeCallback(function(\Rxnet\EventStore\Data\WriteEventsCompleted $eventsCompleted) {
        echo "Last event number {$eventsCompleted->getLastEventNumber()} on commit position {$eventsCompleted->getCommitPosition()} \n";
    });
```
### Subscribe
Watch given stream for new events.  
SubscribeCallback will be called when an event appeared

```php
<?php
$eventStore->volatileSubscription('category-test_stream_id')
    ->subscribeCallback(function(\Rxnet\EventStore\EventRecord $event) {
        echo "received {$event->getId()} event {$event->getType()} ({$event->getNumber()}) with id {$event->getId()} on {$event->getStreamId()} \n";
    });
```

Read all events from position 100, when everything is read, watch for new events (like volatile)
```php
<?php
$eventStore->catchUpSubscription('category-test_stream_id', 100)
    ->subscribeCallback(function(\Rxnet\EventStore\EventRecord $event) {
        echo "received {$event->getId()} event {$event->getType()} ({$event->getNumber()}) with id {$event->getId()} on {$event->getStreamId()} \n";
    });
```
### Read
```php
<?php
$eventStore->readEventsForward('category-test_stream_id', 0, 100)
    ->subscribeCallback(function(\Rxnet\EventStore\EventRecord $event) {
        echo "received {$event->getId()} event {$event->getType()} ({$event->getNumber()}) with id {$event->getId()} on {$event->getStreamId()} \n";
    });
```
```php
<?php
$eventStore->readEventsBackWard('category-test_stream_id', 100, 10)
    ->subscribeCallback(function(\Rxnet\EventStore\EventRecord $event) {
        echo "received {$event->getId()} event {$event->getType()} ({$event->getNumber()}) with id {$event->getId()} on {$event->getStreamId()} \n";
    });
```
```php
<?php
$eventStore->readEvent('category-test_stream_id', 0)
    ->subscribeCallback(function(\Rxnet\EventStore\EventRecord $event) {
        echo "received {$event->getId()} event {$event->getType()} ({$event->getNumber()}) with id {$event->getId()} on {$event->getStreamId()} \n";
    });
```


## Contribute

If ClientMessageDtos.proto is modified, you must generate new php class
```bash
./vendor/bin/protobuf --include-descriptors -i . -o ./src ./ClientMessageDtos.proto
```