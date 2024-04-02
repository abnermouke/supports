<?php

namespace Abnermouke\Supports\Builders\Table\Items;

/**
 * 标记内容元素构建器
 */
class Mark extends Builder
{

    /**
     * 构造函数
     * @param $field
     */
    public function __construct($field)
    {
        //引入父级
        parent::__construct('mark', $field);
        //设置默认参数
        $this->bold()->theme()->label('')->tip();
    }

    /**
     * 获取提示模版
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 14:13:49
     * @param $template
     * @return Mark
     */
    public function tip($template = '')
    {
        //设置提示模版
        return $this->setExtra('tip', $template);
    }

}
