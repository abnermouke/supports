<?php

namespace Abnermouke\Supports\Providers;

use Abnermouke\Supports\Library\HelperLibrary;
use Abnermouke\Supports\Library\LoggerLibrary;
use Yansongda\Pay\Pay;

/**
 * 支付宝服务提供者
 */
class AlipayProvider
{

    //配置信息
    private $configs;

    //订单数据
    private $order_data;

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
        $this->configs = array_merge([
            'app_auth_token' => '',
            'service_provider_id' => '',
            'mode' => Pay::MODE_NORMAL,
        ], $configs);
    }

    /**
     * 转账到个人支付宝（单笔））
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 00:39:52
     * @param $steam_no string 转账流水号（商户自行生成，唯一）
     * @param $amount float 转账金额（元）
     * @param $login_id string 支付宝用户名（邮箱｜手机号码，支付宝 - 个人中心 - 设置查看）
     * @param $true_name string 支付宝绑定真实姓名
     * @param $content string 备注内容
     * @return array|false
     * @throws \Yansongda\Pay\Exception\ContainerException
     * @throws \Yansongda\Pay\Exception\InvalidParamsException
     */
    public function transferToProfile($steam_no, $amount, $login_id, $true_name, $content = '')
    {
        //整理基本参数
        $biz_content = [
            'out_biz_no' => $steam_no,
            'trans_amount' => $amount,
            'product_code' => 'TRANS_ACCOUNT_NO_PWD',
            'biz_scene' => 'DIRECT_TRANSFER',
            'order_title' => $content ? $content : (HelperLibrary::formatDatetime().'代发款项'),
            'payee_info' => [
                'identity' => $login_id,
                'identity_type' => 'ALIPAY_LOGON_ID',
                'name' => $true_name
            ],
            'remark' => $content,
        ];
        //实例化应用
        Pay::config($this->getConfigs());
        //开始单笔转账
        $allPlugins = Pay::alipay()->mergeCommonPlugins([TransUniTransferPlugin::class]);
        //开始支付
        $result = Pay::alipay()->pay($allPlugins, $biz_content)->get();
        //判断是否支付成功
        if ($trans_no = data_get($result, 'order_id', false)) {
            //返回成功
            return ['steam_no' => $steam_no, 'trans_no' => $trans_no, 'time' => strtotime($result['trans_date'])];
        }
        //返回失败
        return false;
    }

    /**
     * 设置订单数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 01:11:20
     * @param $order_data string 订单数据
     * @return $this
     */
    public function setOrderData($order_data)
    {
        //设置订单数据
        $this->order_data = $order_data;
        //返回当前实例
        return $this;
    }

    /**
     * 获取支付宝Wap支付参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 01:13:51
     * @return string
     * @throws \Yansongda\Pay\Exception\ContainerException
     */
    public function wap()
    {
        //实例化应用
        Pay::config($this->getConfigs());
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
        Pay::config($this->getConfigs());
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
     * 支付宝回调处理
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 01:17:53
     * @return array|false
     * @throws \Yansongda\Pay\Exception\ContainerException
     * @throws \Yansongda\Pay\Exception\InvalidParamsException
     */
    public function notify()
    {
        //实例化应用
        Pay::config($this->getConfigs());
        //获取回调结果
        $result = Pay::alipay()->callback();
        //记录信息
        LoggerLibrary::record('alipay.payments.alert', $result);
        //判断是否支付成功
        if (data_get($result, 'trade_status', '') == 'TRADE_SUCCESS') {
            //返回成功
            return ['result' => $result, 'notifyBack' => Pay::alipay()->success()];
        }
        //返回失败
        return false;
    }

    /**
     * 获取支付宝配置参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 01:13:00
     * @return array[]
     */
    private function getConfigs()
    {
        //整理参数
        return [
            'alipay' => [
                'default' => $this->configs
            ]
        ];
    }




}
