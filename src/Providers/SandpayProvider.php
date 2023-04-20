<?php

namespace Abnermouke\Supports\Providers;

use Abnermouke\Supports\Providers\Sandpay\HmfProvider;

/**
 * 杉德支付服务提供者
 */
class SandpayProvider
{

    //支付信息
    private $order_data = [];

    /**
     * 创建杉德支付实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 18:08:54
     * @return SandpayProvider
     */
    public static function make()
    {
        //生成实例
        return (new SandpayProvider());
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
     * 生成河马付实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 18:08:46
     * @param $mer_no
     * @return HmfProvider
     */
    public function hmf($mer_no)
    {
        //生成河马付实例
        return (new HmfProvider($mer_no, $this->order_data));
    }




}
