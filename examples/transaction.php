<?php

use EventLoop\EventLoop;
use Rxnet\EventStore\Data\TransactionCommitCompleted;
use Rxnet\EventStore\Data\TransactionWriteCompleted;
use Rxnet\EventStore\NewEvent\JsonEvent;
use Rxnet\EventStore\Transaction;

require __DIR__.'/../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\EventStore();

$eventStore->connect()
    ->subscribe(function () use ($eventStore) {
        echo "connected\n";
        $eventStore->startTransaction('domain-test.fr')
            ->subscribe(
                function (Transaction $transaction) {
                    echo "Started transaction {$transaction->getId()} \n";
                    $eventA = new JsonEvent('/truc/chose', ['i' => "coucou"]);
                    $eventB = new JsonEvent('/truc/chose', ['i' => "coucou"]);
                    $eventC = new JsonEvent('/truc/chose', ['i' => "coucou"]);

                    return $transaction->write([$eventA, $eventB, $eventC])
                        ->do(
                            function (TransactionWriteCompleted $completed) {
                                echo "Written transaction {$completed->getTransactionId()} \n";
                            }
                        )
                        ->flatMap(
                            function () use ($transaction) {
                                echo "Commit \n";
                                return $transaction->commit();
                            }
                        )
                        ->subscribe(
                            function (TransactionCommitCompleted $commitCompleted) {
                                echo "Transaction {$commitCompleted->getTransactionId()} commit completed : events from {$commitCompleted->getFirstEventNumber()} to {$commitCompleted->getLastEventNumber()} \n";
                            }
                        );
                });
    });

EventLoop::getLoop()->run();