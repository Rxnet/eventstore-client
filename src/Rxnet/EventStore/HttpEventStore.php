<?php
namespace Rxnet\EventStore;

use EventLoop\EventLoop;
use GuzzleHttp\Psr7\Response;
use React\EventLoop\LoopInterface;
use Rxnet\EventStore\NewEvent\NewEventInterface;
use Rxnet\Http\Http;

class HttpEventStore
{
    protected $http;
    protected $loop;
    protected $server;

    public function __construct($server = "http://127.0.0.1:2113", Http $http = null, LoopInterface $loop = null)
    {
        $this->server = $server;
        $this->http = $http ?: new Http();
        $this->loop = $loop ?: EventLoop::getLoop();
    }

    /**
     * @param $streamId
     * @param NewEventInterface[] $events
     * @param null $expectedVersion
     * @return \Rx\Observable
     */
    public function write($streamId, $events, $expectedVersion = null)
    {
        if (!is_array($events)) {
            $events = [$events];
        }
        if (!$events) {
            throw new \LogicException('No events added');
        }
        $url = "{$this->server}/streams/{$streamId}";

        $headers = [
            "Content-Type" => "application/vnd.eventstore.events+json"
        ];
        if ($expectedVersion) {
            $headers['ES-ExpectedVersion'] = $expectedVersion;
        }
        $json = [];


        foreach ($events as $event) {
            $json[] = $event->toArray();
        }
        $body = json_encode($json);

        $headers['Length'] = strlen($body);
        return $this->http->post($url, compact('headers', 'body'))
            ->map(function(Response $response)  {
                $code = $response->getStatusCode();
                if($code == 401) {
                    throw new \LogicException("Must include an event type with the request either in body or as ES-EventType header", 401);
                }
                if($code == 400) {
                    throw new \LogicException("Wrong expected EventNumber", 400);
                }
                return current($response->getHeader('location'));
            });
    }
}