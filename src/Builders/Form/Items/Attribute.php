<?php

namespace Abnermouke\Supports\Builders\Form\Items;

/**
 * 属性内容构建器
 */
class Attribute extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $label
     */
    public function __construct($field, $label)
    {
        //引入父级构造
        parent::__construct('attribute', $field, $label);
        //设置默认属性
        $this->column()->texts();
    }

    /**
     * 设置属性名信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-26 15:19:26
     * @param $label
     * @param $type
     * @param $mode
     * @param $maxlength
     * @return Attribute|m.\Abnermouke\Supports\Builders\Form\Items\Attribute.setExtra
     */
    public function column($label = '属性', $type = 'text', $mode = 'text', $maxlength = -1)
    {
        //设置属性名信息
        return $this->setExtra('column', compact('label', 'type', 'mode', 'maxlength'));
    }

    /**
     * 设置文本提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:00:31
     * @param $create
     * @param $delete
     * @return Attribute
     */
    public function texts($create = '', $delete = '删除全部')
    {
        //初始化信息
        $create = $create ?: '添加'.$this->builder['extras']['column']['label'];
        //设置文本提示
        return $this->setExtra('texts', compact('create', 'delete'));
    }

}
