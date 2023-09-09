<?php

namespace Services\Logger;


use Services\EventBus\PortAdapter\RabbitMQ\RabbitMQService;
use Services\Logger\DTO\LoggerDTO;
use Services\Logger\Formatter\LoggerFormatter;

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
