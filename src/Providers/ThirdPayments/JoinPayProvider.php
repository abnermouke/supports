<?php

namespace Abnermouke\Supports\Providers\ThirdPayments;

use Abnermouke\Supports\Assists\Str;
use Abnermouke\Supports\Providers\ThirdPayments\JoinPay\PaymentProvider;
use Abnermouke\Supports\Providers\ThirdPayments\JoinPay\QueryProvider;

/**
 * 汇聚支付服务提供者
 * @property PaymentProvider $payment
 * @property QueryProvider $query
 */
class JoinPayProvider
{

    //配置参数
    private $configs = [
        'base_uri' => 'https://www.joinpay.com/',               //基础请求域名
        'timeout' => 60.0,                                      //请求超时
        'merchant_no' => '',                                    //商户编号
        'trade_merchant_no' => '',                              //报备商户号
        'key_md5' => '',                                        //MD5密钥
        'private_key_md5' => '',                                //快捷支付私钥（MD5）
        'jp_public_key' => '',                                  //汇聚公钥
        'mch_private_key' => '',                                //商户私钥
        'sec_key' => '',                                        //RSA加密后的AES密钥
        'cur' => 1,                                             //交易币种（1:人民币）
        'notify_uri' => '',                                     //回调链接
        'weixin_app_id' => '',                                  //微信APPID
        'weixin_mp_app_id' => '',                               //微信公众号APPID
        'weixin_mini_app_id' => '',                             //微信小程序APPID
    ];

    /**
     * 注册配置
     * @param $configs
     */
    public function __construct(array $configs = [])
    {
        //设置配置信息
        $this->configs = $configs ? array_merge($this->configs, $configs) : $this->configs;
    }


    /**
     * 调用服务
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 15:29:34
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        //设置命名空间
        $namespace = Str::studly($name).'Provider';
        //整理class
        $class = "\\Abnermouke\\Supports\\Providers\\ThirdPayments\\JoinPay\\{$namespace}";
        //调用参数
        return new $class($this->configs);
    }



}
