<?php

namespace Superbolt\Core\Tests;

use GuzzleHttp\Handler\MockHandler;
use PHPUnit\Framework\TestCase;
use Superbolt\Core\Tests\Fixtures\SuccessfulResponse;
use Superbolt\Core\Tests\Support\ServiceAwareTest;

class CronPingTest extends TestCase
{
    use ServiceAwareTest;

    private const TOKEN = 'db7c7978a4742dae4d9c6e544db2e803';

    public function test_sending_successful_start_ping(): void
    {
        $handler = new MockHandler([new SuccessfulResponse(self::TOKEN)]);

        $service = $this->getService($handler);

        $apiResponse = $service->sendStartPing('thunder:struck', '* * * * *', 'test');

        $this->assertEquals(200, $apiResponse->getGuzzleResponse()->getStatusCode());
        $this->assertEquals(self::TOKEN, $apiResponse->getCronToken());
    }

    public function test_sending_successful_finish_ping(): void
    {
        $handler = new MockHandler([new SuccessfulResponse(self::TOKEN)]);

        $service = $this->getService($handler);

        $apiResponse = $service->sendFinishPing(self::TOKEN, 0);

        $this->assertEquals(200, $apiResponse->getGuzzleResponse()->getStatusCode());
        $this->assertEquals(self::TOKEN, $apiResponse->getCronToken());
    }
}
