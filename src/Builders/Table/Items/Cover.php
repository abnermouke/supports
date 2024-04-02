<?php

namespace Abnermouke\Supports\Builders\Table\Items;

/**
 * 封面图内容元素构建器
 */
class Cover extends Builder
{

    /**
     * 构造函数
     * @param $field
     */
    public function __construct($field)
    {
        //引入父级
        parent::__construct('cover', $field);
    }

}
