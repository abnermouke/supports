<?php

namespace Abnermouke\Supports\Builders\Table\Filters;

/**
 * 输入框筛选构建器
 */
class Input extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $name
     */
    public function __construct($field, $name)
    {
        //引入父级构造
        parent::__construct('input', $field, $name);
        //设置默认构建器参数
        $this->placeholder('请输入'.$name.'等关键词')->input_type();
    }

    /**
     * 设置默认占位符
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:03:10
     * @param $placeholder
     * @return Input
     */
    public function placeholder($placeholder = '')
    {
        //设置默认占位符
        return $this->setExtra('placeholder', $placeholder);
    }

    /**
     * 设置文本框类型
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-20 16:40:18
     * @param $type
     * @return Input
     */
    public function input_type($type = 'text')
    {
        //设置文本框类型
        return $this->setExtra('input_type', $type);
    }


}
