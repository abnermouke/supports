<?php

namespace Abnermouke\Supports\Builders\Infos\Items;

/**
 * 图片内容构建器
 */
class Images extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $name
     */
    public function __construct($field, $name)
    {
        //引入父级构造
        parent::__construct('images', $field, $name);
        //设置默认信息
        $this->circle(false);
    }

    /**
     * 设置是否为圆形图片
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-05 23:39:06
     * @param $circle
     * @return Images
     */
    public function circle($circle = true) {
        //设置是否为圆形图片
        return $this->setExtra('circle', $circle);
    }


}
