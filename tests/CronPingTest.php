<?php

namespace Superbolt\Core\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Superbolt\Core\Api;
use Superbolt\Core\Cron;

class CronPingTest extends TestCase
{
    public function test_sending_successful_start_ping(): void
    {
        $handler = new MockHandler([
            new GuzzleResponse(200, [], json_encode(['data' => ['cron_token' => 'db7c7978a4742dae4d9c6e544db2e803']], JSON_THROW_ON_ERROR, 512)),
        ]);

        $service = $this->getService($handler);

        $apiResponse = $service->sendStartPing('thunder:struck', '* * * * *', 'test');

        $this->assertEquals(200, $apiResponse->getGuzzleResponse()->getStatusCode());
        $this->assertEquals('db7c7978a4742dae4d9c6e544db2e803', $apiResponse->getCronToken());
    }

    public function test_sending_successful_finish_ping(): void
    {
        $handler = new MockHandler([
            new GuzzleResponse(200, [], json_encode(['data' => ['cron_token' => 'db7c7978a4742dae4d9c6e544db2e803']], JSON_THROW_ON_ERROR, 512)),
        ]);

        $service = $this->getService($handler);

        $apiResponse = $service->sendFinishPing('db7c7978a4742dae4d9c6e544db2e803', 0);

        $this->assertEquals(200, $apiResponse->getGuzzleResponse()->getStatusCode());
        $this->assertEquals('db7c7978a4742dae4d9c6e544db2e803', $apiResponse->getCronToken());
    }

    public function test_sending_successful_log(): void
    {
        $data = [
            'data' => [
                'cron_token' => 'db7c7978a4742dae4d9c6e544db2e803',
                'trace' => 'Thunderstruck, Thunderstruck, Thunderstruck, Thunderstruck It\'s alright, we\'re doin\' fine It\'s alright, we\'re doin\' fine, fine, fine Thunderstruck, yeah, yeah, yeah Thunderstruck, Thunderstruck Thunderstruck, baby, baby Thunderstruck, you\'ve been Thunderstruck Thunderstruck, Thunderstruck You\'ve been Thunderstruck',
                'exit_code' => 0,
            ]
        ];

        $handler = new MockHandler([
            new GuzzleResponse(200, [], json_encode($data, JSON_THROW_ON_ERROR, 512)),
        ]);

        $service = $this->getService($handler);

        $apiResponse = $service->sendFinishPing('db7c7978a4742dae4d9c6e544db2e803', 0);

        $this->assertEquals(200, $apiResponse->getGuzzleResponse()->getStatusCode());
        $this->assertEquals('db7c7978a4742dae4d9c6e544db2e803', $apiResponse->getCronToken());
    }

    private function getService(MockHandler $handler): Cron
    {
        $handlerStack = HandlerStack::create($handler);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Api('test-api-key');
        $api->setClient($client);
        return new Cron($api);
    }
}
