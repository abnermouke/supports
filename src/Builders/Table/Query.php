<?php

namespace Abnermouke\Supports\Builders\Table;

/**
 * 表格请求构建器
 */
class Query
{

    //整理默认构建数据
    private $contents = [];


    /**
     * 创建请求信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:36:57
     * @param $alias
     * @param $name
     * @param $post_url
     * @param $default
     * @return $this
     */
    public function create($alias, $name, $post_url, $default = false)
    {
        //初始化信息
        $url = $post_url;
        //设置信息
        $count = 0;
        //设置信息
        $this->contents[] = compact('alias', 'name', 'url', 'count', 'default');
        //返回当前实例
        return $this;
    }

    /**
     * 获取请求配置信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:54:50
     * @return array
     */
    public function get()
    {
        //返回数据
        return ['enable' => !empty($this->contents), 'contents' => $this->contents];
    }

}
