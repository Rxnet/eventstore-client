<?php
require_once 'vendor/autoload.php';
use Prophecy\Argument;
use React\EventLoop\LoopInterface;
use Rx\Observable;
use Rxnet\Connector\Tcp;
use Rxnet\Dns\Dns;
use Rxnet\EventStore\EventStore;
use Rxnet\EventStore\ReadBuffer;
use Rxnet\EventStore\Writer;

describe('EventStore', function () {
    beforeEach(function () {
        $prophet = $this->getProphet();
        /* @var \Prophecy\Prophet $prophet */
        $this->dns = $prophet->prophesize(Dns::class);
        $this->loop = $prophet->prophesize(LoopInterface::class);
        $this->connector = $prophet->prophesize(Tcp::class);
        $this->stream = new Rx\Subject\Subject();
        $this->writer = $prophet->prophesize(Writer::class);
        $this->readBuffer = new ReadBuffer();
        $this->eventStore = new EventStore(
            $this->loop->reveal(),
            $this->dns->reveal(),
            $this->connector->reveal(),
            $this->readBuffer,
            $this->writer->reveal()
        );
    });
    context('->connect', function () {
        beforeEach(function () {
            $this->dns
                ->resolve(Argument::any())
                ->willReturn(Observable::just('127.0.0.1'));

            $this->connector
                ->setTimeout(1000)
                ->willReturn($this->connector);
            $this->connector
                ->connect('127.0.0.1', 1113)
                ->willReturn(
                    Observable::just(
                        new \Rxnet\Event\ConnectorEvent('connected', $this->stream)
                    )
                );
        });
        it('Resolve host DNS Connect TCP client', function () {
            $observable = $this->eventStore->connect();
            expect($observable)->to->be->an->instanceof(Observable::class);
        });
        it('Forward all data received on socket to the read buffer', function () {
            $ok = false;
            $this->readBuffer->subscribeCallback(function ($data) use (&$ok) {
                $ok = $data;
            });

            $this->eventStore->connect()->subscribeCallback();

            $message = new \Rxnet\EventStore\Data\SubscriptionDropped();
            $writer = new Writer();
            $message = $writer->compose(\Rxnet\EventStore\Message\MessageType::SUBSCRIPTION_DROPPED, $message);
            $bin = $writer->encode($message);
            $this->stream->onNext(new \Rxnet\Stream\StreamEvent('data', $bin));

            expect($ok)->instanceof(\Rxnet\EventStore\Message\SocketMessage::class);

        });
        it('Close tcp connection on dispose', function () {

        });
        it('Start listening for heartbeat request when connected', function () {

        });
    });

    context('->appendToStream', function () {

    });

    context('->persistentSubscription', function () {
        beforeEach(function () {
            $this->writer->createUUIDIfNeeded()->willReturn(md5(time()));
            $this->writer->composeAndWriteOnce(Argument::any(), Argument::any(), Argument::any())
                ->willReturn(Observable::emptyObservable());
        });
        it('Returns an observable, that will retry the whole process on error', function () {
            expect($this->eventStore->persistentSubscription('test', 'test'))->to->be->an->instanceof(Observable::class);
        });
        it('Disposing the observable send an unsubscribe command', function () {
            $disposable = $this->eventStore->persistentSubscription('test', 'test')->subscribeCallback();
            $disposable->dispose();

            $this->writer->composeAndWriteOnce(\Rxnet\EventStore\Message\MessageType::UNSUBSCRIBE_FROM_STREAM, Argument::any())
                ->shouldHaveBeenCalled();

        });
        it('Throw an exception on subscription dropped', function() {

        });
        it('Emit an AcknowledgeableEventRecord when an event appeared', function() {

        });
    });
});