<?php

namespace Superbolt\Core;

use \Psr\Http\Message\ResponseInterface;

final class Response {

    /** @var array */
    private $data;

    /** @var ResponseInterface */
    private $rawResponse;

    public function __construct(ResponseInterface $guzzleResponse)
    {
        $this->rawResponse = $guzzleResponse;
        $decoded = json_decode($guzzleResponse->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        $this->data = $decoded['data'];
    }

    public function get($key)
    {
        return $this->data[$key];
    }

    public function getGuzzleResponse(): ResponseInterface
    {
        return $this->rawResponse;
    }

    public function getCronToken(): ?string
    {
        return $this->get('cron_token');
    }
}
