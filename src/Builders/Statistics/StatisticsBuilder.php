<?php

namespace Abnermouke\Supports\Builders\Statistics;

class StatisticsBuilder
{

    //整理构建器基本参数
    private $contents = [];


    /**
     * 构造函数
     * @param $value string 显示数据
     * @param $name string 显示名称
     */
    public function __construct($value, $name = '')
    {
        //设置默认构建器信息
        $this->name($name)->value($value)->image()->target();
    }

    /**
     * 设置显示名称
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:13:03
     * @param $name
     * @return $this
     */
    protected function name($name = '')
    {
        //设置显示名称
        return $this->set('name', $name);
    }

    /**
     * 设置显示数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:13:07
     * @param $value
     * @return $this
     */
    protected function value($value = '')
    {
        //设置显示数据
        return $this->set('value', $value);
    }


    /**
     * 设置显示图片
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:13:27
     * @param $link
     * @return $this
     */
    public function image($link = '')
    {
        //设置显示图片
        return $this->set('image', $link);
    }

    /**
     * 设置跳转链接
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:50:48
     * @param $alias
     * @param $params
     * @return $this
     */
    public function target($alias = 'none', $params = [])
    {
        //设置跳转链接
        return $this->setExtra('click', compact('alias', 'params'));
    }

    /**
     * 配置统计模块构建信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:37:31
     * @param $key
     * @param $value
     * @return $this
     */
    private function set($key, $value)
    {
        //设置信息
        $this->contents[$key] = $value;
        //返回当前实例
        return $this;
    }

    /**
     * 设置统计模块额外构建信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:37:06
     * @param $key
     * @param $value
     * @return $this
     */
    private function setExtra($key, $value)
    {
        //设置信息
        $this->contents['extras'][$key] = $value;
        //返回当前实例
        return $this;
    }

    /**
     * 获取统计模块信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:36:51
     * @return array
     */
    public function get()
    {
        //返回信息
        return $this->contents;
    }

}
