<?php

namespace Abnermouke\Supports\Frameworks\Laravel\Modules;

use Abnermouke\Supports\Modules\ServiceModule;

/**
 * 基础服务容器类
 */
class BaseService extends ServiceModule
{

    /**
     * 构造函数
     * @param $pass bool 是否直接获取结果
     */
    public function __construct($pass = false)
    {
        //引用父级构造
        parent::__construct($pass);
    }

}
