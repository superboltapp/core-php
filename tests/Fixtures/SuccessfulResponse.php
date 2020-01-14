<?php

namespace Superbolt\Core\Tests\Fixtures;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

final class SuccessfulResponse
{
    /** @var string */
    private $token;

    /** @var array */
    private $attributes;

    public function __construct(string $token, array $attributes = [])
    {
        $this->token = $token;
        $this->attributes = $attributes;
    }

    public function __invoke()
    {
        return new GuzzleResponse(200, [], $this->encodedData());
    }

    private function encodedData(): string
    {
        $data['cron_token'] = $this->token;

        foreach ($this->attributes as $key => $value) {
            $data[$key] = $value;
        }

        return json_encode(['data' => $data], JSON_THROW_ON_ERROR, 512);
    }
}
