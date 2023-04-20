<?php

namespace Abnermouke\Supports\Providers;

use Abnermouke\Supports\Providers\Alipay\PaymentProvider;
use Abnermouke\Supports\Providers\Alipay\TransferProvider;
use Yansongda\Pay\Pay;

/**
 * 支付宝服务提供者
 */
class AlipayProvider
{

    //配置信息
    private $configs;

    /**
     * 创建服务提供者实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 00:35:08
     * @param $app_id string 支付宝分配的 app_id
     * @param $app_secret_cert string 应用私钥 字符串或路径
     * @param $app_public_cert_path string 应用公钥证书 路径
     * @param $alipay_public_cert_path string 支付宝公钥证书 路径
     * @param $alipay_root_cert_path string 支付宝根证书 路径
     * @param $return_url string 返回地址
     * @param $notify_url string 回调通知地址
     * @return AlipayProvider
     */
    public static function make($app_id, $app_secret_cert, $app_public_cert_path, $alipay_public_cert_path, $alipay_root_cert_path, $return_url, $notify_url)
    {
        //实例化服务提供者
        return (new AlipayProvider(compact('app_id', 'app_secret_cert', 'app_public_cert_path', 'alipay_public_cert_path', 'alipay_root_cert_path', 'return_url', 'notify_url')));
    }

    /**
     * 创建服务提供者实例（根据配置一键生成）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 00:36:42
     * @param $configs array ['app_id', 'app_secret_cert', 'app_public_cert_path', 'alipay_public_cert_path', 'alipay_root_cert_path', 'return_url', 'notify_url']
     * @return AlipayProvider
     */
    public static function makeByConfigs($configs)
    {
        //实例化服务提供者
        return (new AlipayProvider($configs));
    }

    /**
     * 构造函数
     * @param $configs
     */
    public function __construct($configs)
    {
        //设置配置信息
        $this->configs = [
            'alipay' => [
                'default' => array_merge([
                    'app_auth_token' => '',
                    'service_provider_id' => '',
                    'mode' => Pay::MODE_NORMAL,
                ], $configs)
            ]
        ];
    }

    /**
     * 生成转账实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 17:11:27
     * @return TransferProvider
     */
    public function transfer()
    {
        //返回支付宝转账实例
        return (new TransferProvider($this->configs));
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
        //返回支付宝支付实例
        return (new PaymentProvider($this->configs));
    }


}
