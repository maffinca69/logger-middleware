<?php

namespace Services\Logger\Formatter;

use Services\Logger\DTO\LoggerDTO;

class LoggerFormatter
{
    public function format(LoggerDTO $loggerDTO): array
    {
        return [
            'app_name' => $loggerDTO->getAppName(),
            'request' => $loggerDTO->getRequest(),
            'response' => $loggerDTO->getResponse(),
            'user_agent' => $loggerDTO->getUserAgent(),
            'ip' => $loggerDTO->getIp(),
            'route' => $loggerDTO->getRoute(),
            'pid' => $loggerDTO->getPid()
        ];
    }
}
