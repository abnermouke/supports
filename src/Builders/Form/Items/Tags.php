<?php

namespace Abnermouke\Supports\Builders\Form\Items;

/**
 * 标签内容构建器
 */
class Tags extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $label
     */
    public function __construct($field, $label)
    {
        //引入父级构造
        parent::__construct('tags', $field, $label);
        //设置默认参数
        $this->placeholder('请输入'.$label)->tip('右侧输入框确认生成标签')->maxlength()->input_mode()->input_type()->setExtra('currentValue', '');
    }

    /**
     * 设置标签占位符
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:06:36
     * @param $placeholder
     * @return Tags
     */
    public function placeholder($placeholder = '')
    {
        //设置标签占位符
        return $this->setExtra('placeholder', $placeholder);
    }

    /**
     * 设置限制录入最大长度
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:06:42
     * @param $length
     * @return Tags
     */
    public function maxlength($length = -1)
    {
        //设置限制录入最大长度
        return $this->setExtra('maxlength', $length);
    }

    /**
     * 设置标签数据类型
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:06:46
     * @param $mode
     * @return Tags
     */
    public function input_mode($mode = 'text')
    {
        //设置标签数据类型
        return $this->setExtra('inputMode', $mode);
    }
    /**
     * 设置标签数据类型
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:06:46
     * @param $type
     * @return Tags
     */
    public function input_type($type = 'text')
    {
        //设置标签数据类型
        return $this->setExtra('inputType', $type);
    }
}
