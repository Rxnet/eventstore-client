<?php
use EventLoop\EventLoop;
use Rx\Observer\CallbackObserver;
use Rx\Scheduler\EventLoopScheduler;
use Rxnet\EventStore\Data\WriteEventsCompleted;
use Rxnet\EventStore\NewEvent\JsonEvent;

require '../vendor/autoload.php';
//$loop = new \Rxnet\Loop\LibEvLoop();
//EventLoop::setLoop($loop);

echo 'connecting';
$eventStore = new \Rxnet\EventStore\EventStore();
\Rxnet\await($eventStore->connect());

echo "connected \n";

\Rx\Observable::interval(10)
    ->flatMap(
        function ($i) use ($eventStore) {
            echo '.';
            $event = new JsonEvent('/truc/chose', [ "crypto"=> "btc",
      "user_id"=> "21433R4G523TO",
      "wallet_id"=> "PIH21B4T93VB5T9G7V"]);
            return $eventStore->write('test-test-1.fr', [$event]);
        }
    )
    ->subscribe(
        new CallbackObserver(
            function (WriteEventsCompleted $eventsCompleted) {
                gc_collect_cycles();
                $memory = memory_get_usage(true) / 1024 / 1024;
                echo "Last event number {$eventsCompleted->getLastEventNumber()} on commit position {$eventsCompleted->getCommitPosition()} {$memory}Mb \n";
            }
        ),
        new EventLoopScheduler(EventLoop::getLoop())
    );

EventLoop::getLoop()->run();
