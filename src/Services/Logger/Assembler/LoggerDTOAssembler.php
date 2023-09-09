<?php

namespace Maffinca69\Logger\Services\Logger\Assembler;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maffinca69\Logger\Services\Logger\DTO\LoggerDTO;

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
            request: json_encode($request->all()),
            response: $response->getContent(),
            ip: $request->ip(),
            userAgent: $request->userAgent() ?? 'unknown',
            pid: sha1(time()),
            route: $request->decodedPath()
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
