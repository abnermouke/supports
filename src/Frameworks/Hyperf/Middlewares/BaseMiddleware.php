<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Context\Context;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use function Hyperf\Config\config;

class BaseMiddleware implements MiddlewareInterface
{

    protected RequestInterface $request;
    protected HttpResponse $response;


    public function __construct(protected ContainerInterface $container, HttpResponse $response)
    {
        //设置响应
        $this->response = $response;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //设置全局配置信息
        set_global_data('__LOGIC_REQUEST_LOG_TIME__', time());
        //设置响应信息
        Context::set(HttpResponse::class, $this->response);
        //继续请求
        return $handler->handle($request);
    }
}
