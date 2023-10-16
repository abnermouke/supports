<?php

namespace Abnermouke\Supports\Builders;

use Abnermouke\Supports\Assists\Str;

/**
 * 通用构建器
 * @method static \Abnermouke\Supports\Builders\NoticeBar\Builder noticeBar()
 * @method static \Abnermouke\Supports\Builders\Table\Builder table()
 * @method static \Abnermouke\Supports\Builders\Form\Builder form()
 */
class Builder
{

    /**
     * 静态调用
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:53:18
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        //设置命名空间
        $namespace = Str::studly($name);
        //设置构建器
        $builder = "\\Abnermouke\\Supports\\Builders\\{$namespace}\\Builder";
        //返回实例
        return new $builder;
    }
}
