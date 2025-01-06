<?php

namespace Abnermouke\Supports\Library;

/**
 * 响应类
 */
class ResponseLibrary
{
    /**
     * 响应结果
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-03-04 19:32:55
     * @param int $code 处理编码
     * @param array $data 处理数据集合
     * @param string $message 提示文本
     * @param array $extras 追加参数
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
     * 创建通用响应结果
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-03-07 01:12:47
     * @param int $code
     * @param array $data
     * @param string $message
     * @param array $extras
     * @return object
     */
    public static function make(int $code, array $data = [], string $message = '', array $extras = []): object
    {
        //返回响应结果
        return (new ResponseLibrary())->response($code, $data, $message, $extras);
    }


}
