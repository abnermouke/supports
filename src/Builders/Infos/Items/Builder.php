<?php

namespace Abnermouke\Supports\Builders\Infos\Items;

/**
 * 信息展示内容元素构建器
 */
class Builder
{

    /**
     * 构造参数
     * @var array
     */
    protected $builder = [];

    /**
     * 构造函数
     * @param $type
     * @param $field
     * @param $name
     */
    public function __construct($type, $field, $name)
    {
        //设置默认信息
        $this->set('field', $field)->set('type', $type)->set('name', $name)->bold(false)->theme(\Abnermouke\Supports\Builders\Route\Builder::THEME_OF_DEFAULT);
    }

    /**
     * 设置是否加粗字体显示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-05 22:05:21
     * @param $bold
     * @return $this
     */
    public function bold($bold = true)
    {
        //设置是否加粗字体显示
        return $this->set('bold', $bold);
    }

    /**
     * 设置显示主题色
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-05 22:05:16
     * @param $theme
     * @return $this
     */
    public function theme($theme = \Abnermouke\Supports\Builders\Route\Builder::THEME_OF_PRIMARY)
    {
        //设置显示主题色
        return $this->set('theme', $theme);
    }

    /**
     * 设置构建器参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-05 22:04:33
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
     * @Time 2023-11-05 22:04:19
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
     * @Time 2023-11-05 22:04:26
     * @return array|mixed
     */
    public function get()
    {
        //返回构建器内容
        return $this->builder;
    }

}
