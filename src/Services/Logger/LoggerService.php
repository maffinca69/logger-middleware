<?php

namespace Maffinca69\Logger\Services\Logger;

use Maffinca69\Logger\Services\EventBus\PortAdapter\RabbitMQ\RabbitMQService;
use Maffinca69\Logger\Services\Logger\DTO\LoggerDTO;
use Maffinca69\Logger\Services\Logger\Formatter\LoggerFormatter;

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
