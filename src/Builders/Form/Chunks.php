<?php

namespace Abnermouke\Supports\Builders\Form;

use Abnermouke\Supports\Assists\Str;

/**
 * 表单组块构建器
 */
class Chunks
{

    //整理默认构建数据
    private $contents = [];

    /**
     * 创建分组信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:37:04
     * @param $fields
     * @param $name
     * @param $alert
     * @param $alert_theme
     * @return $this
     */
    public function create($fields, $name = '', $alert = '', $alert_theme = \Abnermouke\Supports\Builders\Route\Builder::THEME_OF_PRIMARY)
    {
        //判断信息
        $fields = is_string($fields) ? [$fields] : $fields;
        //生成唯一标识
        $alias = strtoupper(Str::random());
        //设置分组信息
        $this->contents[] = compact('alias', 'name', 'fields', 'alert', 'alert_theme');
        //返回当前实例
        return $this;
    }

    /**
     * 获取构建器信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:17:07
     * @return array
     */
    public function get()
    {
        //返回构建器信息
        return ['enable' => !empty($this->contents), 'contents' => $this->contents];
    }

}
