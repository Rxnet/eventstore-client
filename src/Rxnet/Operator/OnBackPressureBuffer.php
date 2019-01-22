<?php

declare(strict_types=1);

namespace Rxnet\Operator;

use Rx\DisposableInterface;
use Rx\ObservableInterface;
use Rx\Observer\CallbackObserver;
use Rx\ObserverInterface;
use Rx\Operator\OperatorInterface;
use Rx\Subject\Subject;

class OnBackPressureBuffer implements OperatorInterface
{
    const OVERFLOW_STRATEGY_DROP_OLDEST = "drop_oldest";
    const OVERFLOW_STRATEGY_DROP_LATEST = "drop_latest";
    const OVERFLOW_STRATEGY_ERROR = "error";
    /**
     * @var Subject
     */
    protected $subject;
    protected $queue;
    protected $capacity = -1;
    protected $overflowStrategy;
    protected $onOverflow;
    protected $pending = false;
    protected $sourceCompleted = false;
    public function __construct($capacity = -1, callable $onOverflow = null, $overflowStrategy = self::OVERFLOW_STRATEGY_ERROR)
    {
        $this->capacity = $capacity;
        $this->onOverflow = $onOverflow;
        $this->overflowStrategy = $overflowStrategy;
        $this->subject = new Subject();
        $this->queue = new \SplQueue();
    }
    /**
     * @param \Rx\ObservableInterface $observable
     * @param \Rx\ObserverInterface $observer
     * @return \Rx\DisposableInterface
     */
    public function __invoke(ObservableInterface $observable, ObserverInterface $observer) : DisposableInterface
    {
        // Send back the subject, that will buffer
        $this->subject->subscribe($observer);
        // Wait for data on stream
        return $observable->subscribe(
            new CallbackObserver(
                function ($next) {
                    // Live stream no queue necessary
                    if (!$this->pending) {
                        // Wait for next request
                        $this->pending = true;
                        $this->subject->onNext($next);
                        return;
                    }
                    if ($this->capacity != -1 && $this->queue->count() >= $this->capacity -1) {
                        if ($this->onOverflow) {
                            $closure = $this->onOverflow;
                            $closure($next);
                        }
                        switch ($this->overflowStrategy) {
                            case self::OVERFLOW_STRATEGY_DROP_LATEST:
                                return;
                            case self::OVERFLOW_STRATEGY_ERROR:
                                $this->subject->onError(new \OutOfBoundsException("Buffer is full with {$this->capacity} elements inside"));
                                break;
                            case self::OVERFLOW_STRATEGY_DROP_OLDEST:
                                $this->queue->pop();
                                break;
                        }
                    }
                    // Add to queue
                    $this->queue->push($next);
                },
                [$this->subject, 'onError'],
                function () {
                    if (!$this->pending) {
                        $this->subject->onCompleted();
                    } else {
                        $this->sourceCompleted = true;
                    }
                }
            )
        );
    }
    public function operator()
    {
        return function () {
            return $this;
        };
    }
    public function request()
    {
        // Queue is finished we can return to live stream
        if ($this->queue->isEmpty()) {
            $this->pending = false;
            if ($this->sourceCompleted) {
                $this->subject->onCompleted();
            }
            return;
        }
        // Take element in order they have been inserted
        $this->subject->onNext($this->queue->shift());
    }
}
