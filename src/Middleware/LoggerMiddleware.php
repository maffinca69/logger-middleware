<?php

use App\Services\Logger\Assembler\LoggerDTOAssembler;
use App\Services\Logger\LoggerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoggerMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly LoggerDTOAssembler $loggerDTOAssembler,
        private readonly LoggerService $loggerService
    ) {
    }

    public function handle(Request $request, Closure $next, string $guard = null): mixed
    {
        /** @var Response $response */
        $response = $next($request);

        $loggerDTO = $this->loggerDTOAssembler->create($request, $response);
        $this->loggerService->log($loggerDTO);

        return $response;
    }
}
