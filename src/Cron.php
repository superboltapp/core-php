<?php

namespace Superbolt\Core;

final class Cron {

    /** @var Api */
    private $api;

    /** @var string */
    private $driver = 'core-php';

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    public function sendStartPing(string $commandName, string $expression, ?string $environment): Response
    {
        return $this->api->post('cron/ping', [
            'type' => 'start',
            'driver' => $this->driver,
            'timestamp' => time(),
            'command' => $commandName,
            'expression' => $expression,
            'environment' => $environment,
        ]);
    }

    public function sendFinishPing(string $cronToken, int $exitCode): Response
    {
        return $this->api->post('cron/ping', [
            'type' => 'finish',
            'driver' => $this->driver,
            'timestamp' => time(),
            'cron_token' => $cronToken,
            'exit_code' => $exitCode,
        ]);
    }

    public function sendLog(string $cronToken, string $trace, int $exitCode): Response
    {
        return $this->api->post('cron/log', [
            'cron_token' => $cronToken,
            'trace' => $trace,
            'exit_code' => $exitCode,
        ]);
    }

    public function setDriver(string $driver): void
    {
        $this->driver = $driver;
    }
}
