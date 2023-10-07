<?php

namespace Maffinca69\Logger\Services\Logger\Assembler;

use Maffinca69\Logger\Services\Logger\DTO\LoggerDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoggerDTOAssembler
{
    private const DEFAULT_APP_NAME = 'unknown';

    /**
     * @param Request $request
     * @param Response $response
     * @return LoggerDTO
     */
    public function create(Request $request, Response $response): LoggerDTO
    {
        return new LoggerDTO(
            appName: $this->getApplicationName(),
            request: json_encode($request->request->all()),
            response: $response->getContent() ?: '',
            ip: $request->getClientIp(),
            userAgent: $request->headers->get('User-Agent', 'Unknown'),
            pid: sha1(time()),
            route: $request->getUri()
        );
    }

    /**
     * @return string
     */
    private function getApplicationName(): string
    {
        return config('app.name') ?? self::DEFAULT_APP_NAME;
    }
}
