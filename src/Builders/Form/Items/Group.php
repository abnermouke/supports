<?php

namespace Abnermouke\Supports\Builders\Form\Items;

/**
 * 分组内容构建器
 */
class Group extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $label
     */
    public function __construct($field, $label)
    {
        //引入父级构造
        parent::__construct('group', $field, $label);
        //设置默认参数
        $this->groups()->tip('')->texts();
    }

    /**
     * 设置分组选项信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-10-30 22:27:13
     * @param $groups
     * @param $name
     * @param $value
     * @param $options
     * @return Group
     */
    public function groups($groups = [], $name = 'name', $value = 'value', $options = 'options')
    {
        //整理全部值
        $option_values = [];
        //循环分组信息
        foreach ($groups as $k => $group) {
            //判断信息
            if ($group[$value]) {
                //循环信息
                foreach ($group[$value] as $val) {
                    //设置信息
                    $option_values[] = $val;
                }
            }
        }
        //设置分组选项内容
        return $this->setExtra('groups', $groups)->setExtra('groupFields', compact('name', 'value', 'options'))->setExtra('values', $option_values);
    }

    /**
     * 设置文本
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-10-30 22:25:19
     * @param $selectAll
     * @param $unselectAll
     * @return Group
     */
    public function texts($selectAll = '全部选中', $unselectAll = '清空选中')
    {
        //设置文本
        return $this->setExtra('texts', compact('selectAll', 'unselectAll'));
    }
}
