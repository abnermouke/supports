<?php

namespace Abnermouke\Supports\Builders\Table\Filters;

use Abnermouke\Supports\Assists\Arr;

/**
 * 选项筛选构建器
 */
class Options extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $name
     */
    public function __construct($field, $name)
    {
        //引入父级构造
        parent::__construct('options', $field, $name);
        //设置默认
        $this->values([])->multiple(false);
    }

    /**
     * 选项值集合
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:36:36
     * @param $values array [value1 => name1, value2 => name2]
     * @return Options
     */
    public function values($values)
    {
        //设置选项内容
        return $this->setExtra('values', $values)->collapse((count($values) > 5));
    }

    /**
     * 设置开起折叠面板
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:37:18
     * @param $collapse
     * @param $more
     * @param $pack
     * @return Options
     */
    private function collapse($collapse = true, $more = '更多', $pack = '收起')
    {
        //截取制定长度值
        $collapse_values = Arr::only($this->builder['extras']['values'], array_slice(array_keys($this->builder['extras']['values']), 0, 5));
        //设置开起折叠面板
        return $this->setExtra('collapse', $collapse)->setExtra('collapse_more', $more)->setExtra('collapse_pack', $pack)->setExtra('collapse_all_values', $this->builder['extras']['values'])->setExtra('collapse_values', $collapse_values)->setExtra('values', $collapse_values);
    }

    /**
     * 设置是否可多选
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:33:02
     * @param $multiple
     * @return Options
     */
    public function multiple($multiple = true)
    {
        //设置是否可多选
        return $this->setExtra('multiple', $multiple);
    }

}
