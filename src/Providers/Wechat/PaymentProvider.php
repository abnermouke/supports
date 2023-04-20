<?php

namespace Abnermouke\Supports\Providers\Wechat;

use Abnermouke\Supports\Library\LoggerLibrary;
use Yansongda\Pay\Pay;

/**
 * 微信支付服务提供者
 */
class PaymentProvider
{

    //配置信息
    private $configs;

    //支付信息
    private $order_data;

    /**
     * 构造函数
     * @param $configs array 微信支付参数
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
     * 获取微信公众号支付参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 17:34:59
     * @param $mp_wechat_open_id string 公众号用户OPENID
     * @return mixed
     * @throws \Yansongda\Pay\Exception\ContainerException
     */
    public function office_account($mp_wechat_open_id)
    {
        //实例化应用
        Pay::config($this->configs);
        //整理下单信息
        $order = [
            'out_trade_no' => $this->order_data['out_trade_no'],
            'description' => $this->order_data['description'],
            'amount' => [
                'total' => (int)$this->order_data['amount'],
            ],
            'payer' => [
                'openid' => $mp_wechat_open_id,
            ],
        ];
        //获取支付参数集合
        return Pay::wechat()->mp($order)->get();
    }

    /**
     * 获取微信WAP支付参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 17:35:29
     * @return mixed
     * @throws \Yansongda\Pay\Exception\ContainerException
     */
    public function wap()
    {
        //实例化应用
        Pay::config($this->configs);
        //整理下单信息
        $order = [
            'out_trade_no' => $this->order_data['out_trade_no'],
            'description' => $this->order_data['description'],
            'amount' => [
                'total' => (int)$this->order_data['amount'],
            ],
            'scene_info' => [
                'payer_client_ip' => $this->order_data['ip'],
                'h5_info' => ['type' => 'Wap']
            ],
        ];
        //获取支付参数集合
        return Pay::wechat()->wap($order)->get();
    }

    /**
     * 获取微信小程序支付参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 17:35:59
     * @param $mini_wechat_open_id string 微信小程序用户OPENID
     * @return mixed
     * @throws \Yansongda\Pay\Exception\ContainerException
     */
    public function mini_programing($mini_wechat_open_id)
    {
        //实例化应用
        Pay::config($this->configs);
        //整理下单信息
        $order = [
            'out_trade_no' => $this->order_data['out_trade_no'],
            'description' => $this->order_data['description'],
            'amount' => [
                'total' => (int)$this->order_data['amount'],
                'currency' => $this->order_data['currency'],
            ],
            'payer' => [
                'openid' => $mini_wechat_open_id,
            ]
        ];
        //获取支付参数集合
        return Pay::wechat()->mini($order)->get();
    }

    /**
     * 获取微信APP支付参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 17:36:17
     * @return mixed
     * @throws \Yansongda\Pay\Exception\ContainerException
     */
    public function app()
    {
        //实例化应用
        Pay::config($this->configs);
        //整理下单信息
        $order = [
            'out_trade_no' => $$this->order_datadata['out_trade_no'],
            'description' => $this->order_data['description'],
            'amount' => [
                'total' => (int)$this->order_data['amount'],
            ],
        ];
        //获取支付参数集合
        return Pay::wechat()->app($order)->get();
    }

    /**
     * 判断微信支付回调
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 15:07:40
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
        $result = Pay::wechat()->callback();
        //整理数据
        $result = data_get($result, 'resource.ciphertext', []);
        //记录信息
        LoggerLibrary::record('wechat.payments.alert', $result);
        //获取支付订单号
        $trade_order_sn = $result['out_trade_no'];
        //判断类型
        switch ($result['trade_type']) {
            case 'MWEB':
                // 用户是否支付成功
                if (data_get($result, 'trade_state') === 'SUCCESS') {
                    //执行回调
                    $successCallBack($result['out_trade_no'], $result['transaction_id'], '微信支付', $result);
                }
                break;
            default:
                //判断通讯状态
                if ($result['trade_state'] === 'SUCCESS') {
                    // 用户是否支付成功
                    if (data_get($result, 'transaction_id', false)) {
                        //执行回调
                        $successCallBack($result['out_trade_no'], $result['transaction_id'], '微信支付', $result);
                    }
                }
                break;
        }
        //返回接受消息成功
        return Pay::wechat()->success();
    }

}
