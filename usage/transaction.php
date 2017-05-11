<?php
use EventLoop\EventLoop;
use Rx\Observer\CallbackObserver;
use Rx\Scheduler\EventLoopScheduler;
use Rxnet\EventStore\Data\TransactionCommitCompleted;
use Rxnet\EventStore\Transaction;

require '../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\EventStore();
\Rxnet\await($eventStore->connect('online-10.4x.fr'));

$eventStore->startTransaction('domain-test.fr')
    ->flatMap(function (Transaction $transaction) {
        echo "Started transaction {$transaction->getId()} \n";
        return $transaction->jsonEvent('/truc/chose', ['i' => 1])->write()
            ->doOnCompleted(function() {
                echo 'completed';
            })
            ->concat($transaction->commit());
    })
    ->subscribe(
        new CallbackObserver(
            function (TransactionCommitCompleted $commitCompleted) {
                echo "Transaction {$commitCompleted->getTransactionId()} : last event number {$commitCompleted->getLastEventNumber()} on commit position {$commitCompleted->getCommitPosition()} \n";
            }
        ),
        new EventLoopScheduler(EventLoop::getLoop())
    );

EventLoop::getLoop()->run();