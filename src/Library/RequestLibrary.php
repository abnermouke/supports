<?php

namespace Abnermouke\Supports\Library;

use Abnermouke\Supports\Assists\File;
use Abnermouke\Supports\Frameworks\Laravel\Library\StorageFileLibrary;
use GuzzleHttp\Client;

/**
 * 通用请求类
 */
class RequestLibrary
{

    //超时时间
    private int $timeout;
    //请求链接
    private string $url;
    //请求方式
    private string $method;
    //请求头
    private array $headers = [];
    //请求参数
    private array $params;
    //请求配置
    private array $options;
    //请求解惑
    private mixed $results;

    /**
     * 构造函数
     * @param string $url
     * @param array $params
     * @throws \Exception
     */
    public function __construct(string $url, array $params)
    {
        //设置基础参数
        $this->url = $url;
        //设置默认参数
        $this->timeout(30)->headers([
            'verify' => false,
            'User-Agent' => FakeUserAgentLibrary::random()
        ])->params($params)->method('post');
    }

    /**
     * 发起请求
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-12-10 22:43:06
     * @return $this
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function request(): static
    {
        //创建请求实例
        $client = new Client(['timeout' => $this->timeout]);
        //尝试发起请求
        try {
            //发起请求
            $response = $client->request($this->method, $this->url, $this->options);
            //判断请求状态码
            if ($response->getStatusCode() !== 200) {
                //抛出异常
                throw new \Exception('请求失败，状态码：'.$response->getStatusCode());
            }
            //获取结果内容
            $this->results = $response->getBody()->getContents();
        } catch (\Exception $exception) {
            //抛出异常
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
        //返回当前实例
        return $this;
    }

    /**
     * 表单提交（application/x-www-form-urlencoded）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-12-10 22:44:49
     * @return $this|BaseRequest
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function form(): static
    {
        //初始化请求参数
        $this->options = [
            'headers' => $this->headers,
            'form_prams' => $this->params
        ];
        //发起请求
        return $this->request();
    }

    /**
     * JSON提交（application/json）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-12-10 22:44:49
     * @return $this|BaseRequest
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function json(): static
    {
        //初始化请求参数
        $this->options = [
            'headers' => $this->headers,
            'json' => $this->params
        ];
        //发起请求
        return $this->request();
    }

    /**
     * BODY提交
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-12-10 22:44:49
     * @return $this|BaseRequest
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function body(): static
    {
        //初始化请求参数
        $this->options = [
            'headers' => $this->headers,
            'body' => $this->params
        ];
        //发起请求
        return $this->request();
    }

    /**
     * 获取结果
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-12-10 22:43:14
     * @return mixed
     */
    public function get(): mixed
    {
        //返回结果集合
        return $this->results;
    }

    /**
     * 解码结果
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-12-10 22:43:22
     * @return array
     */
    public function decode(): array
    {
        //返回decode结果
        return json_decode($this->results, true);
    }

    /**
     * 写入文件
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-12-10 22:50:05
     * @param string $storage_name
     * @param string $storage_disk
     * @param int $expire_seconds
     * @return string
     * @throws \Exception
     */
    public function writeFile(string $storage_name, string $storage_disk = 'public', int $expire_seconds = 0): string
    {
        //生成临时文件
        $temporary_file = (new TemporaryFileService(true))->temporary($storage_name, $storage_disk, $expire_seconds);
        //检测目录信息
        StorageFileLibrary::check($storage_name, $storage_disk, true);
        //写入文件
        File::put($temporary_file['file']['storage_path'], $this->results);
        //返回访问链接
        return $temporary_file['file']['link'];
    }

    /**
     * 设置头信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-12-10 22:36:40
     * @param array $headers
     * @return $this
     */
    public function headers(array $headers = []): static
    {
        //判断头信息
        if ($headers) {
            //设置头信息
            $this->headers = $this->headers ? array_merge($this->headers, $headers) : $headers;
        }
        //返回当前实例
        return $this;
    }

    /**
     * 设置超时
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-12-10 22:36:34
     * @param int $timeout
     * @return $this
     */
    public function timeout(int $timeout = 10): static
    {
        //设置超时
        $this->timeout = $timeout;
        //返回当前实例
        return $this;
    }

    /**
     * 设置当前请求方式
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-12-10 22:36:27
     * @param string $method
     * @return $this
     */
    public function method(string $method = 'post'): static
    {
        //设置当前请求方式
        $this->method = $method;
        //返回当前实例
        return $this;
    }

    /**
     * 设置请求参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-12-10 22:36:19
     * @param array $params
     * @return $this
     */
    public function params(array $params = []): static
    {
        //设置请求参数
        $this->params = $params;
        //返回当前实例
        return $this;
    }

    /**
     * 创建实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-12-10 22:36:08
     * @param string $url
     * @param array $params
     * @return BaseRequest
     * @throws \Exception
     */
    public static function make(string $url, array $params = []): BaseRequest
    {
        //创建实例
        return new RequestLibrary($url, $params);
    }


}
