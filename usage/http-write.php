<?php
use EventLoop\EventLoop;
use Rx\Observer\CallbackObserver;
use Rx\Scheduler\EventLoopScheduler;
use Rxnet\EventStore\Data\WriteEventsCompleted;
use Rxnet\EventStore\NewEvent\JsonEvent;

require '../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\HttpEventStore();

\Rx\Observable::interval(10)
    ->flatMap(
        function ($i) use ($eventStore) {
            $uid = \Ramsey\Uuid\Uuid::uuid3(\Ramsey\Uuid\Uuid::NAMESPACE_DNS, 'test.fr');
            $event = new JsonEvent('/truc/chose', ['i' => $i], 'test.fr');

            return $eventStore->write('domain-test3.fr', $event);
        }
    )
    ->subscribe(
        new CallbackObserver(
            function ($eventsCompleted) {

                gc_collect_cycles();
                $memory = memory_get_usage(true) / 1024 / 1024;
                echo $eventsCompleted." {$memory}Mb \n";
                //echo "Last event number {$eventsCompleted->getLastEventNumber()} on commit position {$eventsCompleted->getCommitPosition()} {$memory}Mb \n";
            }
        ),
        new EventLoopScheduler(EventLoop::getLoop())
    );

EventLoop::getLoop()->run();