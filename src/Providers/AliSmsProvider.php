<?php

namespace Abnermouke\Supports\Providers;

use Abnermouke\Supports\Assists\Path;
use Abnermouke\Supports\Library\HelperLibrary;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use Overtrue\EasySms\Strategies\OrderStrategy;

/**
 * Ali短信服务服务提供者
 */
class AliSmsProvider
{

    //配置信息
    private $configs;

    /**
     * 创建服务提供者实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 00:44:55
     * @param $access_key_id string 密钥ID
     * @param $access_key_secret string 密钥
     * @param $sign_name string 签名（审核通过）
     * @return AliSmsProvider
     */
    public static function make($access_key_id, $access_key_secret, $sign_name)
    {
        //实例化服务提供者
        return (new AliSmsProvider(compact('access_key_id', 'access_key_secret', 'sign_name')));
    }

    /**
     * 创建服务提供者实例（根据配置一键生成）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 00:45:43
     * @param $configs array 配置信息 ['access_key_id', 'access_key_secret', 'sign_name']
     * @return AliSmsProvider
     */
    public static function makeByConfigs($configs)
    {
        //实例化服务提供者
        return (new AliSmsProvider($configs));
    }

    /**
     * 构造函数
     * @param $configs
     */
    public function __construct($configs)
    {
        //设置配置信息
        $this->configs = [
            'timeout' => 5.0,
            'default' => [
                'strategy' => OrderStrategy::class,
                'gateways' => ['aliyun']
            ],
            'gateways' => [
                'errlog' => Path::logger().DIRECTORY_SEPARATOR.'easy-sms'.DIRECTORY_SEPARATOR.HelperLibrary::formatDatetime(time(), 'Y-m-d').'.log',
                'aliyun' => $configs
            ],
        ];
    }

    /**
     * 发送短信
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 00:53:46
     * @param $mobile string 手机号码
     * @param $data array 传输参数
     * @param $template string 对应模版（审核通过）
     * @param $content string 短信内容
     * @return bool
     */
    public function send($mobile, $data, $template, $content)
    {
        //整理参数
        $params = [
            'content' => $content,
            'template' => $template,
            'data' => $data
        ];
        //生成处理实例
        $handler = new EasySms($this->configs);
        //尝试发送短信
        try {
            //发送短信
            if (!$handler->send($mobile, $params)) {
                //返回失败
                return false;
            }
        } catch (NoGatewayAvailableException $exception) {
            //返回失败
            return false;
        } catch (\Exception $exception) {
            //返回失败
            return false;
        }
        //返回成功
        return true;
    }


}
