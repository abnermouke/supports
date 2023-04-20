<?php

namespace Abnermouke\Supports\Providers;

use Abnermouke\Supports\Providers\Wechat\PaymentProvider;
use Yansongda\Pay\Pay;

/**
 * 微信服务提供者
 */
class WechatProvider
{

    //配置信息
    private $configs;

    /**
     * 创建服务提供者实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 17:50:41
     * @param $mch_id string 商户号 
     * @param $mch_secret_key string 商户API v3 密钥
     * @param $mch_secret_cert string 商户私钥 字符串或路径
     * @param $mch_public_cert_path string 商户公钥证书路径
     * @param $notify_url string 微信回调url
     * @param $mp_app_id string 公众号 的 app_id
     * @param $mini_app_id string 小程序 的 app_id
     * @param $app_id string app 的 app_id
     * @param $wechat_public_cert_path array 微信平台公钥证书路径 （生成参考：https://blog.csdn.net/fuchto/article/details/122946465）
     * @return WechatProvider
     */
    public static function make($mch_id, $mch_secret_key, $mch_secret_cert, $mch_public_cert_path, $notify_url, $mp_app_id, $mini_app_id, $app_id, $wechat_public_cert_path)
    {
        //实例化服务提供者
        return (new WechatProvider(compact('mch_id', 'mch_secret_key', 'mch_public_cert_path', 'mch_public_cert_path', 'notify_url', 'mp_app_id', 'mini_app_id', 'app_id', 'wechat_public_cert_path')));
    }

    /**
     * 创建服务提供者实例（根据配置一键生成）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 17:50:15
     * @param $configs array ['mch_id', 'mch_secret_key', 'mch_public_cert_path', 'mch_public_cert_path', 'notify_url', 'mp_app_id', 'mini_app_id', 'app_id', 'wechat_public_cert_path']
     * @return WechatProvider
     */
    public static function makeByConfigs($configs)
    {
        //实例化服务提供者
        return (new WechatProvider($configs));
    }

    /**
     * 构造函数
     * @param $configs
     */
    public function __construct($configs)
    {
        //设置配置信息
        $this->configs = [
            'wechat' => [
                'default' => array_merge([
                    'combine_app_id' => '',
                    'combine_mch_id' => '',
                    'sub_mp_app_id' => '',
                    'sub_app_id' => '',
                    'sub_mini_app_id' => '',
                    'sub_mch_id' => '',
                    'mode' => Pay::MODE_NORMAL,
                ], $configs)
            ]
        ];
    }

    /**
     * 生成支付实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 17:12:12
     * @return PaymentProvider
     */
    public function payments()
    {
        //返回微信支付实例
        return (new PaymentProvider($this->configs));
    }

}
