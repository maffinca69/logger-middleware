<?php

namespace Services\Logger\Assembler;

use App\Services\Logger\DTO\LoggerDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoggerDTOAssembler
{
    private const DEFAULT_APP_NAME = 'unknown';

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
