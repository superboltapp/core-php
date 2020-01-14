<?php

namespace Superbolt\Core\Tests\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Superbolt\Core\Api;
use Superbolt\Core\Cron;

trait ServiceAwareTest
{
    private function getService(MockHandler $handler): Cron
    {
        $handlerStack = HandlerStack::create($handler);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Api('test-api-key');
        $api->setClient($client);
        return new Cron($api);
    }
}
