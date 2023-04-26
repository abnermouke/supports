<?php

namespace Abnermouke\Frameworks\Laravel\Middlewares;

use Closure;
use Illuminate\Http\Request;

class BaseSupportsMiddleware
{

    /**
     * 扩展包基础中间件（For Laravel）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 14:35:17
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //记录请求时间
        $request->offsetSet('__LOGIC_REQUEST_LOG_TIME__', time());

        //TODO ：其他中间件操作


        return $next($request);
    }

}
