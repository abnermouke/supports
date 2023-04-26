<?php

namespace Abnermouke\Supports\Providers\Sandpay;

use Abnermouke\Supports\Library\LoggerLibrary;
use Abnermouke\Supports\Providers\Sandpay\Hmf\H5PackProvider;

/**
 * 河马付服务提供者
 */
class HmfProvider
{

    //河马付商户号
    private $mer_no;
    //支付信息
    private $order_data;

    /**
     * 构造函数
     * @param $mer_no
     * @param $order_data
     */
    public function __construct($mer_no, $order_data)
    {
        //设置商户号
        $this->mer_no = $mer_no;
        //设置支付信息
        $this->order_data = $order_data;
    }

    /**
     * 创建H5包装服务实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 08:46:26
     * @return H5PackProvider
     */
    public function h5Pack()
    {
        //返回H5包装实例
        return (new H5PackProvider(['mer_no' => $this->mer_no], $this->order_data));
    }

    /**
     * 判断河马付回调
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 09:42:28
     * @param $payload_data array 回调请求参数（request()->get() || request()->all() 根据实际PHP框架查询）
     * @param \Closure $successCallBack 支付成功处理闭包 function($out_trade_no, $pay_no, $pay_platform, $data) { //TODO : 订单支付成功操作 }
     * @return array
     */
    public function notify($payload_data, \Closure $successCallBack)
    {
        //记录信息
        LoggerLibrary::record('sandpay.paments.alert', $payload_data);
        //判断是否支付成功
        if (data_get($payload_data, 'trade_status', '') == 'TRADE_SUCCESS') {
            //整理支付方式
            $methods = ['WECHAT' => '微信支付', 'ALIPAY' => '支付宝支付', 'UNIONPAY' => '银联支付'];
            //执行回调
            $successCallBack($result['out_order_no'], $result['bank_trx_no'], ('[SANDPAY-HMF] '+data_get($methods, $payload_data['pay_way_code'], '其他')), $payload_data);
        }
        //返回失败
        return json_encode(['SUCCESS']);
    }

}
