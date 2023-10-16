<?php

namespace Abnermouke\Supports\Builders\Form\Items;

/**
 * 参数内容构建器
 */
class Parameter extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $label
     */
    public function __construct($field, $label)
    {
        //引入父级构造
        parent::__construct('parameter', $field, $label);
        //设置默认参数
        $this->key()->value()->texts();
    }

    /**
     * 设置参数名信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-26 15:42:57
     * @param $field
     * @param $label
     * @param $type
     * @param $mode
     * @param $maxlength
     * @return Parameter|m.\Abnermouke\Supports\Builders\Form\Items\Parameter.setExtra
     */
    public function key($field = 'key', $label = '参数名', $type = 'text', $mode = 'text', $maxlength = -1)
    {
        //设置参数名信息
        return $this->setExtra('key', compact('field', 'label', 'type', 'mode', 'maxlength'))->defaultData();
    }

    /**
     * 设置参数值信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-26 15:43:05
     * @param $field
     * @param $label
     * @param $type
     * @param $mode
     * @param $maxlength
     * @return Parameter|m.\Abnermouke\Supports\Builders\Form\Items\Parameter.setExtra
     */
    public function value($field = 'value', $label = '参数值', $type = 'text', $mode = 'text', $maxlength = -1)
    {
        //设置参数值信息
        return $this->setExtra('value', compact('field', 'label', 'type', 'mode', 'maxlength'))->defaultData();
    }

    /**
     * 设置文本提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:00:31
     * @param $create
     * @param $delete
     * @return Parameter
     */
    public function texts($create = '添加', $delete = '删除全部')
    {
        //设置文本提示
        return $this->setExtra('texts', compact('create', 'delete'));
    }

    /**
     * //设置默认添加数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-26 15:46:55
     * @return $this
     */
    private function defaultData()
    {
        //设置默认添加数据
        $this->setExtra('default', [data_get($this->builder, 'extras.key.field', 'key') => '', data_get($this->builder, 'extras.value.field', 'key') => '']);
        //返回当前实例
        return $this;
    }

}
