<?php

namespace Abnermouke\Supports\Builders\Route;

/**
 * 接口路由构建器
 */
class Interfaces extends Builder
{

    /**
     * 构造函数
     * @param $name
     */
    public function __construct($name = '')
    {
        //引入父级构造
        parent::__construct($name, 'interface');
        //设置默认信息
        $this->query('')->after_navigate()->after_reload();
    }

    /**
     * 设置请求信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:06:55
     * @param $post_url
     * @param $params
     * @param $row_fields
     * @return Interfaces
     */
    public function query($post_url, $params = [], $row_fields = [])
    {
        //设置请求链接
        $url = $post_url;
        //设置信息
        return $this->setExtra('query', compact('url', 'params', 'row_fields'));
    }

    /**
     * 设置请求完成后跳转路由
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:12:06
     * @param $res_field string 请求结果res.data中携带跳转参数alias、params的字段
     * @return Interfaces
     */
    public function after_navigate($res_field = 'navigation')
    {
        //设置请求完成后跳转路由
        return $this->setExtra('after', 'navigate')->setExtra('res_field', $res_field);
    }

    /**
     * 设置请求完成后重载页面
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:12:02
     * @return Interfaces
     */
    public function after_reload()
    {
        //设置请求完成后重载页面
        return $this->setExtra('after', 'reload');
    }


}
