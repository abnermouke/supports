<?php

namespace Abnermouke\Supports\Builders\Table\Items;

/**
 * 标签内容元素构建器
 */
class Tags extends Builder
{

    /**
     * 构造函数
     * @param $field
     */
    public function __construct($field)
    {
        //引入父级
        parent::__construct('tags', $field);
        //设置默认参数
        $this->invalid_placeholder('');
    }

}
