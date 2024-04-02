<?php

namespace Abnermouke\Supports\Builders\Table\Items;

/**
 * 头部元素构建器
 */
class Header extends Builder
{

    /**
     * 构造函数
     * @param $field
     */
    public function __construct($field)
    {
        //引入父级
        parent::__construct('header', $field);
        //设置默认参数
        $this->bold()->label('')->clipboard()->bottom_line(false);
    }

    /**
     * 设置图片字段
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-10-30 15:21:25
     * @param $te$fieldmplate
     * @return Header
     */
    public function cover($field = '')
    {
        //设置图片模版
        return $this->setExtra('cover', $field);
    }

    /**
     * bottom_line
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-10-30 16:03:27
     * @param $bottom_line
     * @return Header
     */
    public function bottom_line($bottom_line = true) {
        //设置头部下方是否显示线条分割
        return $this->setExtra('bottom_line', $bottom_line);
    }

    /**
     * 设置复制信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-10-30 15:20:27
     * @param $template
     * @param $hide_content
     * @param $hide_str
     * @return Header
     */
    public function clipboard($template = '', $hide_content = false, $hide_str = '*')
    {
        //设置复制信息
        return $this->setExtra('clipboard', !empty($template))->setExtra('clipboard_configs', compact('template', 'hide_content', 'hide_str'));
    }

}
