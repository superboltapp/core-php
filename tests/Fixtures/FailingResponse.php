<?php

namespace Superbolt\Core\Tests\Fixtures;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

final class FailingResponse
{
    /** @var int */
    private $statusCode;

    /** @var string|bool */
    private $token;

    /** @var array */
    private $attributes;

    public function __construct(?string $token = null, int $statusCode = 500, array $attributes = [])
    {
        $this->token = $token;
        $this->statusCode = $statusCode;
        $this->attributes = $attributes;
    }

    public function __invoke()
    {
        return new GuzzleResponse($this->statusCode, [], $this->encodedData());
    }

    private function encodedData(): ?string
    {
        $data = null;

        if ($this->attributes === [] && $this->token === null) {
            return null;
        }

        if ($this->token !== null) {
            $data['cron_token'] = $this->token;
        }

        foreach ($this->attributes as $key => $value) {
            $data[$key] = $value;
        }

        return json_encode($data);
    }
}
