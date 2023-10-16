<?php

namespace Abnermouke\Supports\Builders\Route;

/**
 * 路由跳转构建器
 */
class Navigate extends Builder
{

    /**
     * 构造函数
     * @param $name
     */
    public function __construct($name)
    {
        //引入父级构造
        parent::__construct($name, 'navigate');
        //设置默认数据
        $this->target();
    }

    /**
     * 设置跳转路由
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:00:44
     * @param $alias
     * @param $params
     * @param $row_fields
     * @return Navigate
     */
    public function target($alias = 'none', $params = [], $row_fields = [])
    {
        //设置请求参数
        return $this->setExtra('navigate', compact('alias', 'params', 'row_fields'));
    }

}
