<?php

namespace Abnermouke\Supports\Providers\Alipay;

use Yansongda\Pay\Pay;

/**
 * 支付宝转账服务提供者
 */
class TransferProvider
{

    //配置信息
    private $configs;

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
    public function singleProfile($steam_no, $amount, $login_id, $true_name, $content = '')
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
        Pay::config($this->configs);
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

}
