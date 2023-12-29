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
        //配置基础域名
        if (!data_get($this->configs, 'base_uri', false)) {
            //设置默认域名
            $this->configs['base_uri'] = 'https://www.joinpay.com/';
        }
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
     * 获取快捷支付MD5签名
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-27 16:44:18
     * @param array $params
     * @return string
     */
    protected function getFastMd5Signature(array $params): string
    {
        //判断信息
        if (!is_string($params['data'])) {
            //设置信息
            $params['data'] = json_encode($params['data'], JSON_UNESCAPED_UNICODE);
        }
        //移除信息
        $params = HelperLibrary::removeInvalidArray($params);
        //排序参数
        ksort($params);
        //生成加密字符串
        $signature_string = http_build_query($params);
        //生成签名
        return base64_encode(md5($signature_string.'&key='.$this->configs['private_key_md5']));
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
        //获取配置信息
        $configs = $this->configs;
        //生成请求实例
        $client = new Client([
            'base_uri' => $configs['base_uri'],
            'timeout' => $configs['timeout']
        ]);
        //初始化结果
        $result = [data_get($this->configs, '__RESPONSE_PARAMS__.code', 'ra_Code') => data_get($this->configs, '__RESPONSE_PARAMS__.code_value', 0), data_get($this->configs, '__RESPONSE_PARAMS__.message', 'rb_CodeMsg') => 'UNKNOWN'];
        //尝试发起请求
        try {
            //发起请求
            $response = $client->request($method, $url, ($query = [
                'headers' => $headers,
                'form_params' => $params,
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
            //设置信息
            $result['rb_CodeMsg'] = $exception->getMessage();
        }
        //返回结果集
        return $result;
    }

    /**
     * 将公钥进行加密
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-27 16:43:23
     * @param string $data
     * @param string $pubKey
     * @return string
     */
    protected function encryptRSA(string $data, string $pubKey)
    {
        //获取公钥匙
        $pubKey = openssl_get_publickey($pubKey);
        //整理解密信息
        $cryptData = '';
        //开始加密
        if (openssl_public_encrypt($data, $cryptData, $pubKey)) {
            //返回信息
            $cryptData = base64_encode($cryptData);
        }
        //释放公钥
        openssl_free_key($pubKey);
        //返回加密结果
        return $cryptData;
    }

    /**
     * 进行AES加密
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-27 15:37:47
     * @param string $data
     * @param string $secKey
     * @return false|string
     */
    protected function encryptECB(string $data, string $secKey)
    {
        //加密内容
        $encrypted = openssl_encrypt($data, 'AES-128-ECB', $secKey, OPENSSL_RAW_DATA);
        //返回加密结果
        return $encrypted ? base64_encode($encrypted) : false;
    }

    /**
     * 进行AES解密
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-27 15:38:33
     * @param string $data
     * @param string $secKey
     * @return false|string
     */
    protected function decryptECB(string $data, string $secKey)
    {
        //加密内容
        return openssl_decrypt(base64_decode($data), self::EBC_MODE, $secKey, OPENSSL_RAW_DATA);
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
