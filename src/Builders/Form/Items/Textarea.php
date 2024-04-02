<?php

namespace Abnermouke\Supports\Builders\Form\Items;

/**
 * 文本域内容构建器
 */
class Textarea extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $label
     */
    public function __construct($field, $label)
    {
        //引入父级构造
        parent::__construct('textarea', $field, $label);
        //设置默认参数
        $this->placeholder('请输入'.$label)->maxlength()->input_mode();
    }

    /**
     * 设置文本域占位符
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:06:36
     * @param $placeholder
     * @return Textarea
     */
    public function placeholder($placeholder = '')
    {
        //设置文本域占位符
        return $this->setExtra('placeholder', $placeholder);
    }

    /**
     * 设置限制录入最大长度
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:06:42
     * @param $length
     * @return Textarea
     */
    public function maxlength($length = -1)
    {
        //设置限制录入最大长度
        return $this->setExtra('maxlength', $length);
    }

    /**
     * 设置文本域数据类型
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:06:46
     * @param $mode
     * @return Textarea
     */
    public function input_mode($mode = 'text')
    {
        //设置文本域数据类型
        return $this->setExtra('inputMode', $mode);
    }
}
