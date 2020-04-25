<?php

namespace Superbolt\Core;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

final class Api
{
    /** @var string */
    private $secret;

    /** @var Client */
    private $client;

    public function __construct(string $apiKey, ?string $endpoint = 'https://superbolt.app/api/v1')
    {
        $this->secret = $apiKey;

        if (mb_substr($endpoint, -1, 1) !== '/') {
            $endpoint .= '/';
        }

        $this->setClient(new Client([
            'base_uri' => $endpoint,
        ]));
    }

    public function post($resource, $data): Response
    {
        $guzzleResponse = $this->client->post($resource, [
            'form_params' => $data,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => "Bearer {$this->secret}",
            ]
        ]);

        return new Response($guzzleResponse);
    }

    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }
}
