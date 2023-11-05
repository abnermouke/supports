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
    }


}
