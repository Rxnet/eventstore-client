<?php

use EventLoop\EventLoop;
use Rxnet\EventStore\Data\TransactionCommitCompleted;
use Rxnet\EventStore\Data\TransactionWriteCompleted;
use Rxnet\EventStore\Event\JsonEvent;
use Rxnet\EventStore\Transaction;

require __DIR__.'/../vendor/autoload.php';

$eventStore = new \Rxnet\EventStore\EventStore();

$eventStore->connect()
    ->subscribe(function () use ($eventStore) {
        echo "connected".PHP_EOL;
        $eventStore->startTransaction('domain-test.fr')
            ->subscribe(
                function (Transaction $transaction) {
                    echo "Started transaction {$transaction->getId()}".PHP_EOL;
                    $eventA = new JsonEvent('/foo/bar', ['i' => "coucou"]);
                    $eventB = new JsonEvent('/foo/pub', ['i' => "coucou"]);
                    $eventC = new JsonEvent('/foo/tavern', ['i' => "coucou"]);

                    return $transaction->write([$eventA, $eventB, $eventC])
                        ->do(
                            function (TransactionWriteCompleted $completed) {
                                echo "Written transaction {$completed->getTransactionId()}".PHP_EOL;
                            }
                        )
                        ->flatMap(
                            function () use ($transaction) {
                                echo 'Commit'.PHP_EOL;
                                return $transaction->commit();
                            }
                        )
                        ->subscribe(
                            function (TransactionCommitCompleted $commitCompleted) {
                                echo "Transaction {$commitCompleted->getTransactionId()} commit completed : events from {$commitCompleted->getFirstEventNumber()} to {$commitCompleted->getLastEventNumber()}".PHP_EOL;
                            }
                        );
                });
    });

EventLoop::getLoop()->run();
