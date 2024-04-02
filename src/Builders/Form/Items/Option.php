<?php

namespace Abnermouke\Supports\Builders\Form\Items;

/**
 * 选项内容构建器
 */
class Option extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $label
     */
    public function __construct($field, $label)
    {
        //引入父级构造
        parent::__construct('option', $field, $label);
        //设置默认参数
        $this->options()->multiple(false)->tip('请选择'.$label);
    }

    /**
     * 设置选项内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:53:48
     * @param $options
     * @param $name
     * @param $desc
     * @return Option
     */
    public function options($options = [], $name = 'name', $desc = 'desc', $value = 'value')
    {
        //设置选项内容
        return $this->setExtra('options', $options)->card(count($options) > 3 ? false : true)->setExtra('optionFileds', compact('name', 'desc', 'value'));
    }

    /**
     * 设置为卡片样式
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:15:10
     * @param $card
     * @return Option
     */
    public function card($card = true)
    {
        //设置为卡片样式
        return $this->setExtra('card', $card);
    }

    /**
     * 设置是否为多选
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:51:52
     * @param $multiple
     * @return Option
     */
    public function multiple($multiple = true)
    {
        //设置是否为多选
        return $this->setExtra('multiple', $multiple);
    }

}
