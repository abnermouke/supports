<?php

namespace Abnermouke\Supports\Providers;

/**
 * 综合支付服务提供者
 */
class PaymentsProvider
{

    /**
     * 创建支付实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 01:02:32
     * @param $out_trade_no string 商户订单号（每次唯一）
     * @param $subject string 支付主题
     * @param $amount int 支付金额（单位：分）
     * @param $description string 支付描述
     * @param $ip string 客户端IP
     * @param $quit_url string 取消后返回连接，一般为订单列表页面（完成链接，含http及域名信息）
     * @return PaymentsProvider
     */
    public static function make($out_trade_no, $subject, $amount, $description, $ip, $quit_url = '')
    {
        //整理订单参数
        $order_data = [
            'out_trade_no' => $$trade_order_sn,
            'description' => $description,
            'subject' => $subject,
            'amount' => $amount,
            'total_amount' => $amount/100,
            'ip' => $ip,
            'currency' => 'CNY',
            'quit_url' => $quit_url,
        ];
        //创建实例
        return (new PaymentsProvider($order_data));
    }

    //订单数据
    private $order_data;

    /**
     * 构造函数
     * @param $order_data array 订单支付数据
     */
    public function __construct($order_data)
    {
        //设置订单数据
        $this->order_data = $order_data;
    }

    /**
     * 创建支付宝支付实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 01:06:24
     * @param $configs array 配置参数（设置后不再参考后续参数）
     * @param $app_id string 支付宝分配的 app_id
     * @param $app_secret_cert string 应用私钥 字符串或路径
     * @param $app_public_cert_path string 应用公钥证书 路径
     * @param $alipay_public_cert_path string 支付宝公钥证书 路径
     * @param $alipay_root_cert_path string 支付宝根证书 路径
     * @param $return_url string 返回地址
     * @param $notify_url string 回调通知地址
     * @return AlipayProvider
     */
    public function alipay($configs = [], $app_id = '', $app_secret_cert = '', $app_public_cert_path = '', $alipay_public_cert_path = '', $alipay_root_cert_path = '', $return_url = '', $notify_url = '')
    {
        //创建实例
        return AlipayProvider::makeByConfigs($configs ? $configs : compact('app_id', 'app_secret_cert', 'app_public_cert_path', 'alipay_public_cert_path', 'alipay_root_cert_path', 'return_url', 'notify_url'))->setOrderData($this->order_data);
    }


}
