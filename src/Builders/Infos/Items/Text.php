<?php

namespace Abnermouke\Supports\Builders\Infos\Items;

/**
 * 文本展示构建器
 */
class Text extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $name
     */
    public function __construct($field, $name)
    {
        //引入父级构造
        parent::__construct('text', $field, $name);
        //设置默认参数
        $this->clipboard(false);
    }

    /**
     * 设置允许复制
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-06 00:25:47
     * @param $clipboard
     * @return Text
     */
    public function clipboard($clipboard = true)
    {
        //设置允许复制
        return $this->setExtra('clipboard', $clipboard);
    }


}
