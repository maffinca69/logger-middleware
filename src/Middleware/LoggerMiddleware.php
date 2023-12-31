<?php

namespace Maffinca69\Logger\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maffinca69\Logger\Services\Logger\Assembler\LoggerDTOAssembler;
use Maffinca69\Logger\Services\Logger\LoggerService;
use Symfony\Component\HttpFoundation\Request as RequestAlias;

class LoggerMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly LoggerDTOAssembler $loggerDTOAssembler,
        private readonly LoggerService $loggerService
    ) {
    }

    /**
     * @param Request $request
     * @param \Closure|Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle(Request $request, \Closure|Closure $next, string $guard = null): mixed
    {
        /** @var Response $response */
        $response = $next($request);

        $loggerDTO = $this->loggerDTOAssembler->create($request, $response);
        $this->loggerService->log($loggerDTO);

        return $response;
    }
}
