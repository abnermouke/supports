<?php

namespace Abnermouke\Supports\Builders\Table\Filters;

/**
 * 定位筛选构建器
 */
class Location extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $name
     */
    public function __construct($field, $name)
    {
        //引入父级构造
        parent::__construct('location', $field, $name);
        //设置默认构建器参数
        $this->texts()->amapKey();
    }

    /**
     * 设置定位相关文本
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:00:36
     * @param $loading
     * @param $fail
     * @param $refresh
     * @param $unauthorized
     * @return Location
     */
    public function texts($loading = '正在获取定位...', $fail = '定位失败，请检查设备权限', $refresh = '重新定位', $unauthorized = '未配置地址解析密钥')
    {
        //设置定位相关文本
        return $this->setExtra('texts', compact('loading', 'fail', 'refresh', 'unauthorized'));
    }

    /**
     * 设置高德地图密钥
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-20 17:56:01
     * @param $key
     * @return Location
     */
    public function amapKey($key = '')
    {
        //设置高德地图密钥
        return $this->setExtra('amap_key', $key);
    }

}
