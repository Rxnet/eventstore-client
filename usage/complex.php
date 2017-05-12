<?php
use EventLoop\EventLoop;
use Ramsey\Uuid\Uuid;
use Rx\Observer\CallbackObserver;
use Rx\Scheduler\EventLoopScheduler;
use Rxnet\EventStore\Data\WriteEventsCompleted;
use Rxnet\EventStore\EventRecord;
use Rxnet\EventStore\EventStore;
use Rxnet\EventStore\NewEvent\JsonEvent;
use Rxnet\Httpd\Httpd;
use Rxnet\Httpd\HttpdEvent;
use Rxnet\Operator\OnBackPressureBuffer;

require '../vendor/autoload.php';

$eventStore = new EventStore();
// Wait connexion to be up before starting
\Rxnet\awaitOnce(
    $eventStore->connect()
        ->doOnError(function (\Exception $e) {
            echo "got an error {$e->getMessage()} \n";
        })
        // on error try to reconnect until end of world
        ->retryWhen(function (\Rx\Observable $errors) {
            // Wait 5s between reconnection
            return $errors->delay(5000)
                ->doOnNext(function () {
                    echo "Disconnected, retry\n";
                });
        })
);

// When http is faster than write
// buffer in memory, could have been redis buffer
$memoryBuffer = new OnBackPressureBuffer(
    10000,
    function () {
        echo "Buffer overflow !";
    },
    OnBackPressureBuffer::OVERFLOW_STRATEGY_ERROR
);
// Write to this stream id

// API part :
// Forward to event store when an event is received
$httpd = new Httpd();
$httpd->listen(8082)
    // Don't filter anything and answer ok
    // in real life that would be
    ->map(function (HttpdEvent $event) use ($memoryBuffer) {
        $id = Uuid::uuid4()->toString();
        echo "Received HTTP request {$id} on /test, save an event \n";

        // Answer we handle it
        $event->getResponse()
            ->json(compact('id'));

        // Transform it to an event (do what you want)
        return new JsonEvent(
            '/test/asked',
            ['i' => microtime(true)],
            $id
        );

    })
    // here we buffer until commit finished
    ->lift($memoryBuffer->operator())
    // Write to event store
    ->flatMap(function ($data) use ($eventStore) {
        return $eventStore->write('category-test', $data);
    })
    // Ask for next element in buffer
    ->doOnNext([$memoryBuffer, 'request'])
    // Output some debug when write is complete
    ->subscribe(
        new CallbackObserver(
            function (WriteEventsCompleted $eventsCompleted) {
                echo "Event saved with number {$eventsCompleted->getLastEventNumber()} on commit position {$eventsCompleted->getCommitPosition()} \n";
            }
        ),
        new EventLoopScheduler(EventLoop::getLoop())
    );
echo "HTTPD server listening on http://localhost:8082/test\n";


// Listener part :
// listen for events on given stream and to projection
// persistent subscription is better here
$eventStore->volatileSubscription('category-test', true)
    ->subscribeCallback(function (EventRecord $record) {
        echo "Event received {$record->getNumber()}@{$record->getStreamId()} {$record->getType()} with ID {$record->getId()}\n";
    });


// Make the event loop run
EventLoop::getLoop()->run();