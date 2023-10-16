<?php

namespace Abnermouke\Supports\Builders\Table\Filters;

/**
 * 数值区间筛选构建器
 */
class Range extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $name
     */
    public function __construct($field, $name)
    {
        //引入父级构造
        parent::__construct('range', $field, $name);
        //设置默认参数
        $this->min()->max();
    }

    /**
     * 设置最小数值信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:42:53
     * @param $text
     * @return Range
     */
    public function min($text = '最小数值')
    {
        //设置最小数值信息
        return $this->setExtra('min', $text);
    }

    /**
     * 设置最大数值信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:43:36
     * @param $text
     * @return Range
     */
    public function max($text = '最大数值')
    {
        //设置最大数值信息
        return $this->setExtra('max', $text);
    }

}
