<?php

namespace Abnermouke\Supports\Providers;

use Abnermouke\Supports\Assists\File;
use Abnermouke\Supports\Library\CodeLibrary;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

/**
 * 七牛服务提供者
 */
class QinIuProvider
{

    //配置信息
    private $configs;

    /**
     * 创建服务提供者实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 21:56:54
     * @param $access_key string 密钥KEY
     * @param $access_secret string 密钥
     * @param $bucket string 桶信息
     * @param $domain string 访问域名
     * @return QinIuProvider
     */
    public static function make($access_key, $access_secret, $bucket, $domain)
    {
        //实例化服务提供者
        return (new QinIuProvider(compact('access_key', 'access_secret', 'bucket', 'domain')));
    }

    /**
     * 创建服务提供者实例（根据配置一键生成）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 21:58:28
     * @param $configs array 配置信息（'access_key', 'access_secret', 'bucket', 'domain'）
     * @return QinIuProvider
     */
    public static function makeByConfigs($configs)
    {
        //实例化服务提供者
        return (new QinIuProvider($configs));
    }

    /**
     * 构造函数
     * @param $configs
     */
    public function __construct($configs)
    {
        //设置配置信息
        $this->configs = $configs;
    }

    /**
     * 上传文件（公有云）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 22:06:22
     * @param $path string 本地文件绝对路径
     * @param $qiniu_key string 线上文件路径（除开域名）
     * @param $clear_local_file bool 上传后是否删除本地文件（谨慎操作，不可追回）
     * @return false|string
     * @throws \Exception
     */
    public function put($path, $qiniu_key, $clear_local_file = false)
    {
        //检测路径与配置
        $this->check($path);
        //创建授权实例
        $auth = new Auth(data_get($this->configs, 'access_key', ''), data_get($this->configs, 'access_secret', ''));
        //创建覆盖上传凭证
        $upToken = $auth->uploadToken(data_get($this->configs, 'bucket', ''), $qiniu_key);
        //初始化上传
        $uploadMgr = new UploadManager();
        //上传信息
        list($ret, $err) = $uploadMgr->putFile($upToken, $qiniu_key, $path);
        //判断是否上传成功
        if ($err !== null) {
            //返回失败
            return false;
        }
        //判断是否清除本地文件
        if ($clear_local_file) {
            //删除本地文件
            File::delete($path);
        }
        //返回链接
        return data_get($this->configs, 'domain', false).'/'.$ret['key'];
    }

    /**
     * 删除七牛云文件
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 22:09:07
     * @param $qiniu_key
     * @param $clear_local_file
     * @return bool
     * @throws \Exception
     */
    private function delete($qiniu_key, $clear_local_file = false)
    {
        //检测路径与配置
        $this->check($path);
        //创建授权实例
        $auth = new Auth(data_get($this->configs, 'access_key', ''), data_get($this->configs, 'access_secret', ''));
        //处理bucket
        $bucketManager = new BucketManager($auth, new Config());
        //删除文件
        if ($err = $bucketManager->delete(data_get($this->configs, 'bucket', ''), $qiniu_key)) {
            //返回失败
            return false;
        }
        //判断是否清除本地文件
        if ($clear_local_file) {
            //删除本地文件
            File::delete($path);
        }
        //返回成功
        return true;
    }

    /**
     * 检测数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 22:02:38
     * @param $path string 顺带检查文件绝对路径
     * @return bool
     * @throws \Exception
     */
    private function check($path = false)
    {
        //判断配置信息
        if (data_get($this->configs, 'access_key', false) || data_get($this->configs, 'access_secret', false) || data_get($this->configs, 'bucket', false) || data_get($this->configs, 'domain', false)) {
            //抛出异常
            throw new \Exception('[Missing] 七牛配置信息', CodeLibrary::DATA_MISSING);
        }
        //判断是否验证地址
        if ($path && File::missing($path)) {
            //抛出异常
            throw new \Exception('[Missing] 文件不存在或不可用', CodeLibrary::DATA_MISSING);
        }
        //f返回成功
        return true;
     }


}
