<?php

namespace Abnermouke\Supports\Builders\Infos;

use Abnermouke\Supports\Builders\Route\Interfaces;
use Abnermouke\Supports\Builders\Route\Navigate;

/**
 * 信息展示工具构建器
 */
class Tools
{

    //整理默认构建数据
    private $contents = [];

    /**
     * 创建路由跳转实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:15:51
     * @param $name
     * @return Navigate
     */
    public function navigate($name)
    {
        //创建构建器
        $this->contents[] = $builder = new Navigate($name);
        //返回实例对象
        return $builder;
    }

    /**
     * 创建接口请求实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:16:03
     * @param $name
     * @return Interfaces
     */
    public function interface($name)
    {
        //创建构建器
        $this->contents[] = $builder = new Interfaces($name);
        //返回实例对象
        return $builder;
    }

    /**
     * 获取构建器信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:17:07
     * @return array
     */
    public function get()
    {
        //返回构建器信息
        return ['enable' => !empty($this->contents), 'contents' => $this->contents];
    }

}
