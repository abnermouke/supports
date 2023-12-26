<?php

namespace Abnermouke\Supports\Providers\ThirdPayments\JoinPay;

use Abnermouke\Supports\Assists\Str;
use Abnermouke\Supports\Library\HelperLibrary;
use Abnermouke\Supports\Providers\ThirdPayments\JoinPay\Payments\WechatProvider;
use Abnermouke\Supports\Providers\ThirdPayments\JoinPay\Prepay\PrepayProvider;
use Abnermouke\Supports\Providers\ThirdPayments\JoinPay\Query\QueryProvider;

/**
 * 支付服务提供者
 */
class PaymentProvider
{

    //配置参数
    protected $configs;

    //预下单信息
    protected $prepayData;

    /**
     * 注册配置参数
     * @param array $configs
     */
    public function __construct(array $configs = [])
    {
        //设置参数
        $this->configs = $configs;
    }


    /**
     * 配置预下单信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 15:19:45
     * @param string $out_trade_no 商户订单号
     * @param int $amount 金额（单位：分）
     * @param string $subject 商品名称
     * @param string $description 商品描述
     * @param array $backhaul 回传参数
     * @return $this
     */
    public function prepay(string $out_trade_no, int $amount, string $subject, string $description = '', array $backhaul = [])
    {
        //整理公共预下单参数
        $data = [
            'p0_Version' => $this->configs['version'],
            'p1_MerchantNo' => $this->configs['merchant_no'],
            'p2_OrderNo' => $out_trade_no,
            'p3_Amount' => $amount/100,
            'p4_Cur' => $this->configs['cur'],
            'p5_ProductName' => $subject,
            'p6_ProductDesc' => $description,
            'p9_NotifyUrl' => $this->configs['notify_uri'],
            'qa_TradeMerchantNo' => $this->configs['trade_merchant_no']
        ];
        //判断信息
        if ($description) {
            //设置预下单参数
            $data['p6_ProductDesc'] = $description;
        }
        //判断是否存在回传参数
        if ($backhaul) {
            //设置预下单参数
            $data['p7_Mp'] = json_encode($backhaul);
        }
        //返回对应实例
        return new PrepayProvider($this->configs, $data);
    }


}
