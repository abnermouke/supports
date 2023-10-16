<?php

namespace Abnermouke\Supports\Builders\Table;

/**
 * 表格排序构建器
 */
class Sorts
{

    //整理默认构建数据
    private $contents = [];

    /**
     * 创建排序项目
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:57:32
     * @param $field
     * @param $name
     * @param $table_name
     */
    public function create($field, $name, $table_name = '')
    {
        //整理信息
        $table_field = ($table_name ? ($table_name.'.') : '').$field;
        //设置信息
        $this->contents[] = compact('field', 'table_field', 'name', 'table_name');
    }

    /**
     * 获取排序配置信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:54:50
     * @return array
     */
    public function get()
    {
        //返回数据
        return ['enable' => !empty($this->contents), 'contents' => $this->contents];
    }

}
