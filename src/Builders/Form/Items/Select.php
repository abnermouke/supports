<?php

namespace Abnermouke\Supports\Builders\Form\Items;

use Abnermouke\Supports\Library\HelperLibrary;
use Illuminate\Support\Facades\Storage;

/**
 * 选择框内容构建器
 */
class Select extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $label
     */
    public function __construct($field, $label)
    {
        //引入父级构造
        parent::__construct('select', $field, $label);
        //设置默认参数
        $this->values([])->setExtra('pickerMode', 'selector')->placeholder('点击选择'.$label);
    }

    /**
     * 设置选项信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 10:37:00
     * @param $values
     * @return Select
     */
    public function values($values)
    {
        //设置选项
        return $this->setExtra('values', $values)->setExtra('rangeKey', 'name')->setExtra('selectedNames', [])->setExtra('selectedValue', 0);
    }

    /**
     * 设置为多列
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 10:42:19
     * @param $json_url string JSON文件访问地址 name:显示名称 value:选中后赋值 subs：子集 [{name: '', value: '', subs: [{name: '', value: '', 'subs: []}]}]
     * @param $column
     * @param $separator
     * @return Select
     */
    public function columns($json_url, $column = 2, $separator = ' / ')
    {
        //设置为多列
        return $this->setExtra('pickerMode', 'multiSelector')->set('type', 'multi_select')->setExtra('columnJsonUrl', $json_url)->setExtra('column', $column)->setExtra('separator', $separator);
    }

    /**
     * 设置选择框占位符
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 10:51:16
     * @param $placeholder
     * @return Select
     */
     function placeholder($placeholder = '')
    {
        //设置选择框占位符
        return $this->setExtra('placeholder', $placeholder);
    }


}
