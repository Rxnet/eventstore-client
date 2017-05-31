Event Store Client
==================

Asynchronous client for [EventStore](https://geteventstore.com/) TCP Api

based on [Madkom/event-store-client](https://github.com/madkom/event-store-client)


## Usage
### Connect
```php
<?php
$eventStore = new \Rxnet\EventStore\EventStore();
// Default value
$eventStore->connect('tcp://admin:changeit@localhost:1113');

$eventStore = new \Rxnet\EventStore\EventStore();
// Lazy way, to connect
\Rxnet\await($eventStore->connect());

echo "connected \n";
```

### Write
You can put as many event you want (max 2000)

```php
<?php
$eventA = new \Rxnet\EventStore\NewEvent\JsonEvent('event_type1', ['data' => 'a'], ['worker'=>'metadata']);
$eventB = new \Rxnet\EventStore\NewEvent\RawEvent('event_type2', 'raw data', 'raw metadata');

$eventStore->write('category-test_stream_id', [$eventA, $eventB])
    ->subscribeCallback(function(\Rxnet\EventStore\Data\WriteEventsCompleted $eventsCompleted) {
        echo "Last event number {$eventsCompleted->getLastEventNumber()} on commit position {$eventsCompleted->getCommitPosition()} \n";
    });
```

if you are on a fpm context or don't need persistent connection, you can use HTTP client

```php
<?php
$eventA = new \Rxnet\EventStore\NewEvent\JsonEvent('event_type1', ['data' => 'a'], ['worker'=>'metadata']);
$eventB = new \Rxnet\EventStore\NewEvent\RawEvent('event_type2', 'raw data', 'raw metadata');

$eventStore = new \Rxnet\EventStore\HttpEventStore('http://admin:changeit@127.0.0.1:2113');
$eventStore->write('category-test_stream_id', [$eventA, $eventB])
    ->subscribeCallback(function($lastEventUrl) {
        echo "Last event us at {$lastEventUrl} \n";
    });
```

### Transaction

```php
<?php
$eventStore->startTransaction('category-test_stream')
    ->subscribeCallback(
        function (\Rxnet\EventStore\Transaction $transaction) {
            $eventA = new JsonEvent('event_type', ['i' => "data"]);
            $eventB = new JsonEvent('event_type', ['i' => "data"]);
            // You can write as many as you want
            return $transaction->write([$eventA, $eventB])
                // Commit to make it work
                ->flatMap([$transaction, 'commit'])
                ->subscribeCallback(
                    function (TransactionCommitCompleted $commitCompleted) {
                        echo "Transaction {$commitCompleted->getTransactionId()} commit completed : events from {$commitCompleted->getFirstEventNumber()} to {$commitCompleted->getLastEventNumber()} \n";
                    }
                );
        }
    );
```
### Subscription

Connect to persistent subscription $ce-category (projection) has group my-group, then acknowledge or not
```php
<?php
$eventStore->persistentSubscription('$projection-category', 'my-group')
    ->subscribeCallback(function(\Rxnet\EventStore\AcknowledgeableEventRecord $event) {
        echo "received {$event->getId()} event {$event->getType()} ({$event->getNumber()}) with id {$event->getId()} on {$event->getStreamId()} \n";
        if($event->getNumber() %2) {
            $event->ack();
        }
        else {
            $event->nack($event::NACK_ACTION_RETRY, 'Explain why');
        }
    });
```

Watch given stream for new events.  
SubscribeCallback will be called when a new event appeared

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

Read from event 0 to event 100 on stream category-test_stream_id then end
```php
<?php
$eventStore->readEventsForward('category-test_stream_id', 0, 100)
    ->subscribeCallback(function(\Rxnet\EventStore\EventRecord $event) {
        echo "received {$event->getId()} event {$event->getType()} ({$event->getNumber()}) with id {$event->getId()} on {$event->getStreamId()} \n";
    });
```

Read backward (latest to oldest) from event 100 to event 90 on stream category-test_stream_id then end
```php
<?php
$eventStore->readEventsBackWard('category-test_stream_id', 100, 10)
    ->subscribeCallback(function(\Rxnet\EventStore\EventRecord $event) {
        echo "received {$event->getId()} event {$event->getType()} ({$event->getNumber()}) with id {$event->getId()} on {$event->getStreamId()} \n";
    });
```

Read first event detail from category-test_stream_id
```php
<?php
$eventStore->readEvent('category-test_stream_id', 0)
    ->subscribeCallback(function(\Rxnet\EventStore\EventRecord $event) {
        echo "received {$event->getId()} event {$event->getType()} ({$event->getNumber()}) with id {$event->getId()} on {$event->getStreamId()} \n";
    });
```


## Contribute
### TODO

 - [x] Append event to stream
 - [x] Read given stream
 - [x] Subscribe to given stream
 - [x] Read a huge stream 
 - [x] Persistent subscription
 - [x] Connect to cluster
 - [x] Auto re-connect to master if needed
 - [x] Reconnect and disconnected from remote
 - [x] Transactions
 - [ ] TLS connect
 - [ ] Write some specs
 - [ ] create / update / delete persistent subscription
 - [ ] create / update / delete projection
 - [ ] delete stream

### Protocol buffer
If ClientMessageDtos.proto is modified, you must generate new Data php class
```bash
./vendor/bin/protobuf --include-descriptors -i . -o ./src ./ClientMessageDtos.proto
```
