<?php

namespace Abnermouke\Supports\Providers\ThirdPayments\JoinPay\Prepay;

use Abnermouke\Supports\Assists\Str;

/**
 * 预下单服务
 * @property WechatProvider $wechat
 * @property AlipayProvider $alipay
 */
class PrepayProvider
{


    //预下单信息
    protected $prepayData;

    //配置信息
    protected $configs;

    /**
     * 构造函数
     * @param array $configs
     * @param array $prepayData
     */
    public function __construct(array $configs, array $prepayData)
    {
        //设置配置信息
        $this->configs = $configs;
        //配置预下单信息
        $this->prepayData = $prepayData;
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
        $class = "\\Abnermouke\\Supports\\Providers\\ThirdPayments\\JoinPay\\Prepay\\{$namespace}";
        //调用参数
        return new $class($this->configs, $this->prepayData);
    }
}
