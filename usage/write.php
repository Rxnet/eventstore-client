<?php
require '../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\EventStore();
\Rxnet\await($eventStore->connect());

\Rx\Observable::interval(100)
    ->flatMap(
        function ($i) use ($eventStore) {
            return $eventStore->appendToStream('domain-test.fr')
                ->jsonEvent('/truc/chose', ['i' => $i])
                ->commit();
        }
    )
    ->subscribe(
        new \Rx\Observer\CallbackObserver(
            function(\Rxnet\EventStore\Data\WriteEventsCompleted $eventsCompleted) {
                echo "Last event number {$eventsCompleted->getLastEventNumber()} on commit position {$eventsCompleted->getCommitPosition()} \n";
            }
        ),
        new \Rx\Scheduler\EventLoopScheduler(\EventLoop\EventLoop::getLoop())
    );

\EventLoop\EventLoop::getLoop()->run();