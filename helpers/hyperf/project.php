<?php

declare(strict_types=1);


if (!function_exists('set_global_data')) {
    /**
     * 设置全局数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 01:01:48
     * @param string $key
     * @param mixed $value
     * @return array
     */
    function set_global_data(string $key, mixed $value): array
    {
        //获取全局信息
        $globalData = \Hyperf\Context\Context::get(\Hyperf\Config\config('global_data_alias', '__GLOBAL_DATA__'), []);
        //追加信息
        $globalData[$key] = $value;
        //设置信息
        \Hyperf\Context\Context::set(\Hyperf\Config\config('global_data_alias'), $globalData);
        //返回信息
        return $globalData;
    }
}

if (!function_exists('get_global_data')) {
    /**
     * 获取全局设置数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 01:00:14
     * @param string|bool $item
     * @param mixed|null $default
     * @return mixed
     */
    function get_global_data(string|bool $item = false, mixed $default = null): mixed
    {
        //获取全局信息
        $globalData = \Hyperf\Context\Context::get(\Hyperf\Config\config('global_data_alias', '__GLOBAL_DATA__'));
        //返回信息
        return $item ? data_get($globalData, $item, $default) : $globalData;
    }
}