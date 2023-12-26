<?php

namespace Abnermouke\Supports\Providers\ThirdPayments\JoinPay;

use Abnermouke\Supports\Library\CodeLibrary;
use Abnermouke\Supports\Library\HelperLibrary;
use Abnermouke\Supports\Library\LoggerLibrary;
use GuzzleHttp\Client;

/**
 * 基础服务提供者
 */
class BasicProvider
{

    //配置信息
    protected $configs;

    /**
     * 构造函数
     * @param array $configs
     */
    public function __construct(array $configs)
    {
        //设置配置信息
        $this->configs = $configs;
    }

    /**
     * 获取MD5加密签名
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 15:08:49
     * @param array $params
     * @return string
     */
    protected function getHmcMd5Signature(array $params): string
    {
        //移除信息
        $params = HelperLibrary::removeInvalidArray($params);
        //排序参数
        ksort($params);
        //生成签名
        return urlencode(md5(implode("", $params) . $this->configs['key_md5']));
    }

    /**
     * 发起请求
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 16:16:21
     * @param string $url
     * @param array $params
     * @param string $method
     * @param array $headers
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function httpRequest(string $url, array $params, string $method = 'POST', array $headers = [])
    {
        //生成请求实例
        $client = new Client([
            'base_uri' => $this->configs['base_uri'],
            'timeout' => $this->configs['timeout']
        ]);
        //获取配置信息
        $configs = $this->configs;
        //尝试发起请求
        try {
            //发起请求
            $response = $client->request($method, $url, ($query = [
                'headers' => $headers,
                'json' => $params,
                'verify' => false
            ]));
            //判断处理状态
            if ((int)$response->getStatusCode() !== 200) {
                //抛出错误
                throw new \Exception('接口响应失败', $response->getStatusCode());
            }
            //整理信息
            $result = json_decode($response->getBody()->getContents(), true);
            //记录错误信息
            $message = '发起请求['.$url.']';
            //记录日志
            $this->logger(compact('message', 'configs', 'url', 'query', 'result'));
        } catch (\Exception $exception) {
            //记录错误信息
            $message = '响应异常 -> '.$exception->getMessage();
            //记录日志
            $this->logger(compact('message', 'configs', 'url', 'query'));
        }
        //返回结果集
        return $result;
    }

    /**
     * 记录日志
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 16:13:45
     * @param array $data
     * @return bool
     */
    protected function logger(array $data)
    {
        //记录日志
        return LoggerLibrary::record('joinPay', $data);
    }

    /**
     * 响应结果
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 16:23:40
     * @param int $code
     * @param string $message
     * @param array $data
     * @return object
     */
    protected function response(int $code, string $message, array $data): object
    {
        //获取处理状态
        $state = $code === CodeLibrary::CODE_SUCCESS;
        //返回信息
        return (object)compact('state', 'code', 'message', 'data');
    }
}
