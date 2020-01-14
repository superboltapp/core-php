<?php

namespace Superbolt\Core\Tests;

use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\MockHandler;
use PHPUnit\Framework\TestCase;
use Superbolt\Core\Tests\Fixtures\FailingResponse;
use Superbolt\Core\Tests\Fixtures\SuccessfulResponse;
use Superbolt\Core\Tests\Support\ServiceAwareTest;

class CronLogTest extends TestCase
{
    use ServiceAwareTest;

    private const TOKEN = 'db7c7978a4742dae4d9c6e544db2e803';

    public function test_sending_successful_log(): void
    {
        $data = $this->fakeData();

        $handler = new MockHandler([new SuccessfulResponse(self::TOKEN, $data)]);

        $service = $this->getService($handler);

        $apiResponse = $service->sendLog(self::TOKEN, $data['trace'], $data['exit_code']);

        $this->assertEquals(200, $apiResponse->getGuzzleResponse()->getStatusCode());
        $this->assertEquals(self::TOKEN, $apiResponse->getCronToken());
    }

    public function test_receiving_general_failure(): void
    {
        $this->expectException(ServerException::class);

        $data = $this->fakeData();

        $handler = new MockHandler([new FailingResponse(null, 500)]);

        $service = $this->getService($handler);

        $apiResponse = $service->sendLog(self::TOKEN, $data['trace'], $data['exit_code']);

        $this->assertEquals(500, $apiResponse->getGuzzleResponse()->getStatusCode());
        $this->assertNull($apiResponse->getCronToken());
    }

    private function fakeData(): array
    {
        return [
            'trace' => 'Thunderstruck, Thunderstruck, Thunderstruck, Thunderstruck It\'s alright, we\'re doin\' fine It\'s alright, we\'re doin\' fine, fine, fine Thunderstruck, yeah, yeah, yeah Thunderstruck, Thunderstruck Thunderstruck, baby, baby Thunderstruck, you\'ve been Thunderstruck Thunderstruck, Thunderstruck You\'ve been Thunderstruck',
            'exit_code' => 0,
        ];
    }
}
