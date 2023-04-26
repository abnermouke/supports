<?php

namespace Abnermouke\Frameworks\Laravel\Modules;

use Illuminate\Support\Facades\Cache;

/**
 * 基础缓存处理类
 */
class BaseCacheHandler extends BaseHandler
{

    // cache name
    protected $cache_name = '';

    // cache expire seconds
    protected $expire_seconds = 0;

    //cache result data
    protected $cache = [];

    //cache driver
    protected $driver = 'file';

    //cache env
    protected $env = false;

    //cache locale
    protected $locale = false;

    /**
     * 狗仔函数
     * @param $cache_name
     * @param $expire_seconds
     * @param $driver
     * @param $env
     * @param $locale
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __construct($cache_name, $expire_seconds, $driver, $env = false, $locale = false)
    {
        //init cache env
        $this->env = $env ?: config('app.env', 'production');
        //init cache locale
        $this->locale = $locale ?: config('app.locale', 'zh-cn');
        // init cache name
        $this->cache_name = $this->env.':'.$this->locale.':'.$cache_name;
        //init cache expire seconds
        $this->expire_seconds = (int)$expire_seconds;
        //init cache driver
        $this->driver = !empty($driver) ? $driver : config('cache.default');
        //init read cache
        $this->read();
    }

    /**
     * 保存缓存内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 23:26:51
     * @return bool
     */
    protected function save()
    {
        //init cache
        $cache = [
            'expire_time' => (int)$this->expire_seconds > 0 ? (time() + (int)$this->expire_seconds) : 0,
            'data' => $this->cache
        ];
        //save cache
        return Cache::store($this->driver)->forever($this->cache_name, $cache);
    }

    /**
     * 请空当前缓存内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 23:26:38
     * @return bool
     * @throws \Exception
     */
    public function clear()
    {
        //clear current cache
        $this->cache = [];
        //store current cache
        return $this->save();
    }

    /**
     * 获取缓存指定内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 23:26:19
     * @param $index
     * @param $default
     * @return array|false|mixed
     */
    public function get($index = '', $default = false)
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
        return !empty($this->cache) && isset($this->cache[$index]) ? $this->cache[$index] : $default;
    }

    /**
     * 删除指定缓存
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 23:26:10
     * @return bool
     */
    public function forget()
    {
        //delete cache
        return Cache::store($this->driver)->forget($this->cache_name);
    }

    /**
     * 读取缓存
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 23:26:03
     * @return array|mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function read()
    {
        // set default cache
        $this->cache = [];
        //isset cache
        if (Cache::store($this->driver)->has($this->cache_name)) {
            //get cache
            $cache = Cache::store($this->driver)->get($this->cache_name);
            //check cache expired
            if ((int)$cache['expire_time'] > 0 && (int)$cache['expire_time'] <= time()) {
                //set cache to null
                $cache['data'] = [];
            }
            //set cache value
            $this->cache = $cache['data'];
        }
        //return cache
        return $this->cache;
    }
}
