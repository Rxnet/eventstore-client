<?php
use EventLoop\EventLoop;
use Rx\Observer\CallbackObserver;
use Rx\Scheduler\EventLoopScheduler;
use Rxnet\EventStore\Data\WriteEventsCompleted;
use Rxnet\EventStore\NewEvent\JsonEvent;

require '../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\HttpEventStore();

\Rx\Observable::interval(1000)
    ->flatMap(
        function ($i) use ($eventStore) {
            $event = new JsonEvent('/truc/chose', [
                "crypto" => "btc",
                "user_id" => "21433R4G523TO",
                "wallet_id" => "PIH21B4T93VB5T9G7V"
            ]);

            return $eventStore->write('crypto-exchange-rate', $event);
        }
    )
    ->subscribe(
        new CallbackObserver(
            function ($eventsCompleted) {

                gc_collect_cycles();
                $memory = memory_get_usage(true) / 1024 / 1024;
                echo $eventsCompleted . " {$memory}Mb \n";
                //echo "Last event number {$eventsCompleted->getLastEventNumber()} on commit position {$eventsCompleted->getCommitPosition()} {$memory}Mb \n";
            }
        ),
        new EventLoopScheduler(EventLoop::getLoop())
    );

EventLoop::getLoop()->run();
