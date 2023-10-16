<?php

namespace Abnermouke\Supports\Builders\Table\Items;

/**
 * 描述内容元素构建器
 */
class Desc extends Builder
{

    /**
     * 构造函数
     * @param $field
     */
    public function __construct($field)
    {
        //引入父级
        parent::__construct('desc', $field);
        //设置默认参数
        $this->clipboard();
    }

    /**
     * 设置复制信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:39:01
     * @param $template
     * @param $hide_content
     * @param $hide_str
     * @return Desc
     */
    public function clipboard($template = '', $hide_content = false, $hide_str = '*')
    {
        //设置复制信息
        return $this->setExtra('clipboard', !empty($template))->setExtra('clipboard_configs', compact('template', 'hide_content', 'hide_str'));
    }

}
