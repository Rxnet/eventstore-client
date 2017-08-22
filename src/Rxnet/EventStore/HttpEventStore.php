<?php
namespace Rxnet\EventStore;

use EventLoop\EventLoop;
use GuzzleHttp\Psr7\Response;
use React\EventLoop\LoopInterface;
use Rx\Disposable\CallbackDisposable;
use Rx\Observable;
use Rx\ObserverInterface;
use Rxnet\EventStore\NewEvent\JsonEvent;
use Rxnet\EventStore\NewEvent\NewEventInterface;
use Rxnet\Http\Http;

class HttpEventStore
{
    protected $http;
    protected $loop;
    protected $server;

    public function __construct($server = 'http://admin:changeit@127.0.0.1:2113', Http $http = null, LoopInterface $loop = null)
    {
        $this->server = $server;
        $this->http = $http ?: new Http();
        $this->loop = $loop ?: EventLoop::getLoop();
    }

    /**
     * @param $streamId
     * @param JsonEvent[] $events
     * @param null $expectedVersion
     * @return \Rx\Observable
     * @throws \LogicException
     */
    public function write($streamId, $events, $expectedVersion = null)
    {
        if($events instanceof NewEventInterface) {
            $events = [$events];
        }

        if (!$events) {
            throw new \LogicException('No events added');
        }
        $url = "{$this->server}/streams/{$streamId}";

        $json = [];
        foreach ($events as $event) {
            $json[] = $event->toArray();
        }
        $headers = [
            'Content-Type' => 'application/vnd.eventstore.events+json'
        ];
        if ($expectedVersion) {
            $headers['ES-ExpectedVersion'] = $expectedVersion;
        }


        $body = json_encode($json);
        $headers['Length'] = strlen($body);
        $options = compact('headers', 'body');

        return Observable::create(function(ObserverInterface $observer) use($url, $options) {
            $disposable = $this->http->post($url, $options)
                ->map(function(Response $response)  {
                    $code = $response->getStatusCode();
                    if($code === 401) {
                        throw new \LogicException('Security Denied : must include an event type with the request either in body or as ES-EventType header', 401);
                    }
                    if($code === 400) {
                        throw new \LogicException('Invalid Content for Content Type : wrong expected EventId ?  ', 400);
                    }
                    return current($response->getHeader('location'));
                })
            ->subscribe($observer);

            return new CallbackDisposable(function() use($disposable) {
                $disposable->dispose();
            });
        });
    }
}