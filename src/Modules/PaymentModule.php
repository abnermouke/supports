<?php

namespace Abnermouke\Supports\Modules;

use Abnermouke\Supports\Providers\AlipayProvider;
use Abnermouke\Supports\Providers\SandpayProvider;
use Abnermouke\Supports\Providers\WechatProvider;

/**
 * 支付整合模块
 */
class PaymentModule
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
     * @return PaymentModule
     */
    public static function make($out_trade_no, $subject, $amount, $description, $ip, $quit_url = '')
    {
        //整理订单参数
        $order_data = [
            'out_trade_no' => $$out_trade_no,
            'description' => $description,
            'subject' => $subject,
            'amount' => $amount,
            'total_amount' => $amount/100,
            'ip' => $ip,
            'currency' => 'CNY',
            'quit_url' => $quit_url,
        ];
        //创建实例
        return (new PaymentModule($order_data));
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
     * 创建支付宝支付实例（普通传参模式）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 17:22:52
     * @param $app_id string 支付宝分配的 app_id
     * @param $app_secret_cert string 应用私钥 字符串或路径
     * @param $app_public_cert_path string 应用公钥证书 路径
     * @param $alipay_public_cert_path string 支付宝公钥证书 路径
     * @param $alipay_root_cert_path string 支付宝根证书 路径
     * @param $return_url string 返回地址
     * @param $notify_url string 回调通知地址
     * @return \Abnermouke\Supports\Providers\Alipay\PaymentProvider
     */
    public function alipay($app_id, $app_secret_cert, $app_public_cert_path, $alipay_public_cert_path, $alipay_root_cert_path, $return_url, $notify_url)
    {
        //创建支付宝服务
        return AlipayProvider::makeByConfigs(compact('app_id', 'app_secret_cert', 'app_public_cert_path', 'alipay_public_cert_path', 'alipay_root_cert_path', 'return_url', 'notify_url'))->payments()->setOrderData($this->order_data);
    }

    /**
     * 创建支付宝支付实例（整合配置模式）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 17:23:10
     * @param $configs array 配置参数 ['app_id', 'app_secret_cert', 'app_public_cert_path', 'alipay_public_cert_path', 'alipay_root_cert_path', 'return_url', 'notify_url']
     * @return \Abnermouke\Supports\Providers\Alipay\PaymentProvider
     */
    public function alipayByConfigs($configs)
    {
        //创建支付宝服务
        return AlipayProvider::makeByConfigs($configs)->payments()->setOrderData($this->order_data);
    }

    /**
     * 创建微信支付实例（普通传参模式）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 09:01:06
     * @param $mch_id string 商户号
     * @param $mch_secret_key string 商户API v3 密钥
     * @param $mch_secret_cert string 商户私钥 字符串或路径
     * @param $mch_public_cert_path string 商户公钥证书路径
     * @param $notify_url string 微信回调url
     * @param $mp_app_id string 公众号 的 app_id
     * @param $mini_app_id string 小程序 的 app_id
     * @param $app_id string app 的 app_id
     * @param $wechat_public_cert_path array 微信平台公钥证书路径 （生成参考：https://blog.csdn.net/fuchto/article/details/122946465）
     * @return \Abnermouke\Supports\Providers\Wechat\PaymentProvider
     */
    public function wechat($mch_id, $mch_secret_key, $mch_secret_cert, $mch_public_cert_path, $notify_url, $mp_app_id, $mini_app_id, $app_id, $wechat_public_cert_path)
    {
        //创建微信服务
        return WechatProvider::makeByConfigs(compact('mch_id', 'mch_secret_key', 'mch_public_cert_path', 'mch_public_cert_path', 'notify_url', 'mp_app_id', 'mini_app_id', 'app_id', 'wechat_public_cert_path'))->payments()->setOrderData($this->order_data);
    }

    /**
     * 创建微信支付实例（整合配置模式）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 17:56:16
     * @param $configs array 配置参数 ['mch_id', 'mch_secret_key', 'mch_public_cert_path', 'mch_public_cert_path', 'notify_url', 'mp_app_id', 'mini_app_id', 'app_id', 'wechat_public_cert_path']
     * @return \Abnermouke\Supports\Providers\Wechat\PaymentProvider
     */
    public function wechatByConfigs($configs)
    {
        //创建微信服务
        return WechatProvider::makeByConfigs($configs)->payments()->setOrderData($this->order_data);
    }

    /**
     * 创建杉德支付实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 09:00:03
     * @param $mer_no string 杉德支付下发商户号
     * @param $method string 支付方式（hmf：河马付）
     * @return \Abnermouke\Supports\Providers\Sandpay\HmfProvider|SandpayProvider
     */
    public function sandpay($mer_no, $method = 'hmf')
    {
        //创建杉德支付服务
        $provider = SandpayProvider::make()->setOrderData($this->order_data);
        //判断创建服务方式
        switch ($method) {
            case 'hmf':
                //设置河马付支付服务
                $provider = $provider->hmf($mer_no);
                break;
        }
        //返回服务
        return $provider;
    }

}
