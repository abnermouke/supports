<?php

namespace Abnermouke\Supports\Builders\Table\Filters;

/**
 * 表格筛选构建器
 */
class Builder
{

    //构建器默认数据
    protected $builder = [];

    /**
     * 构造函数
     * @param $type
     * @param $field
     * @param $name
     */
    public function __construct($type, $field, $name)
    {
        //设置默认数据
        $this->set('field', $field)->set('name', $name)->set('type', $type)->set('extras', [])->tip();
    }

    /**
     * 设置文字提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:31:21
     * @param $tip
     * @return $this
     */
    public function tip($tip = '')
    {
        //设置文字提示
        return $this->set('tip', $tip);
    }

    /**
     * 设置构建器参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 22:17:00
     * @param $key
     * @param $value
     * @return $this
     */
    protected function set($key, $value)
    {
        //设置信息
        data_set($this->builder, $key, $value);
        //返回当前实例
        return $this;
    }

    /**
     * 设置构建器额外参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 22:17:09
     * @param $key
     * @param $value
     * @return $this
     */
    public function setExtra($key, $value)
    {
        //设置信息
        data_set($this->builder, 'extras.'.$key, $value);
        //返回当前实例
        return $this;
    }

    /**
     * 获取构建器参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 22:17:15
     * @return array|mixed
     */
    public function get()
    {
        //返回构建器内容
        return $this->builder;
    }

}
