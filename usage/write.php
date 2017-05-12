<?php
use EventLoop\EventLoop;
use Rx\Observer\CallbackObserver;
use Rx\Scheduler\EventLoopScheduler;
use Rxnet\EventStore\Data\WriteEventsCompleted;
use Rxnet\EventStore\NewEvent\JsonEvent;

require '../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\EventStore();
\Rxnet\await($eventStore->connect('online-10.4x.fr'));

\Rx\Observable::interval(5)
    ->flatMap(
        function ($i) use ($eventStore) {
            $event = new JsonEvent('/truc/chose', ['i' => $i]);
            return $eventStore->write('domain-test.fr', [$event]);
        }
    )
    ->subscribe(
        new CallbackObserver(
            function(WriteEventsCompleted $eventsCompleted) {
                echo "Last event number {$eventsCompleted->getLastEventNumber()} on commit position {$eventsCompleted->getCommitPosition()} \n";
            }
        ),
        new EventLoopScheduler(EventLoop::getLoop())
    );

EventLoop::getLoop()->run();