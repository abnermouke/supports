<?php

namespace Abnermouke\Supports\Providers;

use Abnermouke\Supports\Assists\Arr;
use Abnermouke\Supports\Assists\Str;
use Abnermouke\Supports\Providers\ThirdPayments\JoinPayProvider;

/**
 * 三方支付服务提供者
 * @method static JoinPayProvider joinPay($configs)
 */
class ThirdPaymentProvider
{
    
    /**
     * 静态调用
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:53:18
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        //设置命名空间
        $namespace = Str::studly($name);
        //设置构建器
        $builder = "\\Abnermouke\\Supports\\Providers\\ThirdPayments\\{$namespace}Provider";
        //返回实例
        return new $builder(Arr::first($arguments));
    }

}
