<?php

namespace Abnermouke\Supports\Builders\Table\Items;

/**
 * 标题内容元素构建器
 */
class Title extends Builder
{

    /**
     * 构造函数
     * @param $field
     */
    public function __construct($field)
    {
        //引入父级
        parent::__construct('title', $field);
        //设置默认参数
        $this->bold(true)->clipboard();
    }

    /**
     * 设置复制信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:39:01
     * @param $template
     * @param $hide_content
     * @param $hide_str
     * @return Title
     */
    public function clipboard($template = '', $hide_content = false, $hide_str = '*')
    {
        //设置复制信息
        return $this->setExtra('clipboard', !empty($template))->setExtra('clipboard_configs', compact('template', 'hide_content', 'hide_str'));
    }

}
