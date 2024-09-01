<?php

namespace Abnermouke\Supports\Assists;

use Abnermouke\Supports\Library\CodeLibrary;

/**
 * 响应服务方法
 */
class Response
{
    /**
     * 响应结果
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-03 12:53:37
     * @param int $code
     * @param array $data
     * @param string $message
     * @param array $extras
     * @return object
     */
    public function response(int $code, array $data = [], string $message = '', array $extras = []): object
    {
        //设置状态
        $state = $code === CodeLibrary::CODE_SUCCESS;
        //整理信息
        $result = compact('state', 'code', 'data', 'message', 'extras');
        //返回对象信息
        return (object)$result;
    }

    /**
     * 创建通用响应类方法
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-03 12:53:26
     * @param int $code
     * @param array $data
     * @param string $message
     * @param array $extras
     * @return object
     */
    public static function make(int $code, array $data = [], string $message = '', array $extras = []): object
    {
        //返回响应结果
        return (new Response())->response($code, $data, $message, $extras);
    }

}