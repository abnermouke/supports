<?php

declare(strict_types=1);

namespace Abnermouke\Supports\Frameworks\Hyperf\Modules;

use Hyperf\Cache\Cache;
use Hyperf\Cache\CacheManager;
use Hyperf\Context\ApplicationContext;
use Hyperf\Di\Annotation\Inject;
use Psr\SimpleCache\CacheInterface;
use function Hyperf\Config\config;

/**
 * 基础缓存处理类
 */
class BaseCacheHandler
{

    #[Inject]
    protected CacheManager $cacheManager;

    // cache name
    protected string $cache_name = '';

    // cache expire seconds
    protected int $expire_seconds = 0;

    //cache result data
    protected mixed $cache = [];

    //cache driver
    protected string $driver = 'default';

    //cache env
    protected string|bool $env = false;

    /**
     * 构造函数
     * @param string $cache_name
     * @param int $expire_seconds
     * @param string $driver
     * @param string|bool $env
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __construct(string $cache_name, int $expire_seconds, string $driver = 'default', string|bool $env = false)
    {
        //init cache env
        $this->env = $env ?: config('app_env', 'production');
        // init cache name
        $this->cache_name = $this->env.':'.$cache_name;
        //init cache expire seconds
        $this->expire_seconds = (int)$expire_seconds;
        //init cache driver
        $this->driver = $driver ?: 'default';
        //init read cache
        $this->read();
    }

    /**
     * 保存缓存
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 15:06:01
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function save(): bool
    {
        //init cache
        $cache = [
            'expire_time' => (int)$this->expire_seconds > 0 ? (time() + (int)$this->expire_seconds) : 0,
            'data' => $this->cache
        ];
        //save cache
        return $this->cacheManager->getDriver($this->driver)->set($this->cache_name, $cache, (int)$this->expire_seconds > 0 ?: null);
    }

    /**
     * 清除缓存
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 15:05:22
     * @return array|mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function clear(): mixed
    {
        //delete cache
        $this->cacheManager->getDriver($this->driver)->delete($this->cache_name);
        //clear current cache
        $this->cache = [];
        //store current cache
        return $this->cache;
    }

    /**
     * 设置缓存
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 15:28:56
     * @param mixed $value
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function set(mixed $value): mixed
    {
        //设置缓存信息
        $this->cache = $value;
        //保存缓存
        $this->save();
        //返回缓存
        return $value;
    }

    /**
     * 获取缓存
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 15:14:22
     * @param string $index
     * @param mixed $default
     * @return mixed
     */
    public function get(string $index = '', mixed $default = false):mixed
    {
        // without cache
        if (!$this->cache) {
            //return default value
            return $default;
        }
        //check cache format
        if (!is_array($this->cache) || empty($index)) {
            //return cache
            return $this->cache;
        }
        //get cache
        return $index ? data_get($this->cache, $index, $default) : $this->cache;
    }

    /**
     * 读取缓存
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 15:03:31
     * @return array|mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function read(): mixed
    {
        // set default cache
        $this->cache = [];
        //isset cache
        if ($this->cacheManager->getDriver($this->driver)->has($this->cache_name)) {
            //get cache
            $cache = $this->cacheManager->getDriver($this->driver)->get($this->cache_name);
            //check cache expired
            if ((int)$cache['expire_time'] > 0 && (int)$cache['expire_time'] <= time()) {
                //set cache to null
                $cache['data'] = $this->clear();
            }
            //set cache value
            $this->cache = $cache['data'];
        }
        //return cache
        return $this->cache;
    }
}