<?php

namespace Abnermouke\Supports\Providers\Alipay;

use Abnermouke\Supports\Library\LoggerLibrary;
use Yansongda\Pay\Pay;

/**
 * 支付宝支付服务提供者
 */
class PaymentProvider
{

    //配置信息
    private $configs;

    //支付信息
    private $order_data;

    /**
     * 构造函数
     * @param $configs array 支付宝支付参数
     */
    public function __construct($configs)
    {
        //设置配置信息
        $this->configs = $configs;
    }

    /**
     * 设置订单数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 17:07:54
     * @param $data array 订单数据 ['out_trade_no', 'description', 'subject', 'amount', 'total_amount', 'ip', 'currency', 'quit_url']
     * @return $this
     */
    public function setOrderData($data)
    {
        //设置支付信息
        $this->order_data = $data;
        //返回当前实例
        return $this;
    }

    /**
     * 获取支付宝Wap支付参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 16:59:22
     * @return string
     * @throws \Yansongda\Pay\Exception\ContainerException
     */
    public function wap()
    {
        //实例化应用
        Pay::config($this->configs);
        //整理下单信息
        $order = [
            'out_trade_no' => $this->order_data['out_trade_no'],
            'total_amount' => $this->order_data['total_amount'],
            'subject' => $this->order_data['subject'],
            'quit_url' => $this->order_data['quit_url']
        ];
        //获取支付参数集合
        return Pay::alipay()->wap($order)->getBody()->getContents();
    }

    /**
     * 获取支付宝APP支付参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 01:14:38
     * @return string
     * @throws \Yansongda\Pay\Exception\ContainerException
     */
    public function app()
    {
        //实例化应用
        Pay::config($this->configs);
        //整理下单信息
        $order = [
            'out_trade_no' => $this->order_data['out_trade_no'],
            'total_amount' => $this->order_data['total_amount'],
            'subject' => $this->order_data['subject']
        ];
        //获取支付参数集合
        return Pay::alipay()->app($order)->getBody()->getContents();
    }

    /**
     * 判断支付宝支付回调
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 15:02:11
     * @param \Closure $successCallBack 支付成功处理闭包 function($out_trade_no, $pay_no, $pay_platform, $data) { //TODO : 订单支付成功操作 }
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Yansongda\Pay\Exception\ContainerException
     * @throws \Yansongda\Pay\Exception\InvalidParamsException
     */
    public function notify(\Closure $successCallBack)
    {
        //创建支付实例
        Pay::config($this->configs);
        //获取回调结果
        $result = Pay::alipay()->callback();
        //记录信息
        LoggerLibrary::record('alipay.payments.alert', $result);
        //判断是否支付成功
        if (data_get($result, 'trade_status', '') == 'TRADE_SUCCESS') {
            //执行回调
            $successCallBack($result['out_trade_no'], $result['trade_no'], '支付宝支付', $result);
        }
        //返回接受消息成功
        return Pay::alipay()->success();
    }


}
