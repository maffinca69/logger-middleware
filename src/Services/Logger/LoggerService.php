<?php

namespace App\Services\Logger;

use App\Services\EventBus\PortAdapter\RabbitMQ\RabbitMQService;
use App\Services\Logger\DTO\LoggerDTO;
use App\Services\Logger\Formatter\LoggerFormatter;

class LoggerService
{
    public function __construct(
        private readonly LoggerFormatter $formatter,
        private readonly RabbitMQService $rabbitMQService
    ) {
    }

    public function log(LoggerDTO $loggerDTO): void
    {
        $message = $this->formatter->format($loggerDTO);

        $this->rabbitMQService->publish(json_encode($message));
    }
}
