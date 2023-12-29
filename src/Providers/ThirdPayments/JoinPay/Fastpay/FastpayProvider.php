<?php

namespace Abnermouke\Supports\Providers\ThirdPayments\JoinPay\Fastpay;

/**
 * 快捷支付服务
 * @property AgreementProvider $agreement
 * @property DirectProvider $direct
 */
class FastpayProvider
{


    //配置信息
    protected $configs;

    /**
     * 构造函数
     * @param array $configs
     */
    public function __construct(array $configs)
    {
        //设置配置信息
        $this->configs = $configs;
    }

    /**
     * 调用服务
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 15:57:37
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        //设置命名空间
        $namespace = Str::studly($name).'Provider';
        //整理class
        $class = "\\Abnermouke\\Supports\\Providers\\ThirdPayments\\JoinPay\\Fastpay\\{$namespace}";
        //调用参数
        return new $class($this->configs);
    }

}
