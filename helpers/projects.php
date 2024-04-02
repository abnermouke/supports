<?php

/**
 * Power by abnermouke/supports.
 * User: Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
 * Originate: YunniTec <https://www.yunnitec.com/>
 */


/**
 * Power by abnermouke/supports.
 * User: Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
 * Originate: YunniTec <https://www.yunnitec.com/>
 */


if (!function_exists('proxy_assets')) {
    /**
     * 项目资源地址获取
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 14:13:09
     * @param $path string 项目资源路径
     * @param $public_dir string 所属public目录
     * @param $version bool 是否携带版本号（避免缓存）
     * @return string
     */
    function proxy_assets($path, $public_dir = '', $version = false)
    {
        //整理地址对应目录
        $path = config('app.url') . '/' . ($public_dir ? ($public_dir . '/') : '') . $path;
        //判断是否使用第三方存储资源文件
        switch (config('app.env', 'local')) {
            case 'production':

                //TODO : 整理线上第三方代理链接，如：七牛等其他OSS


                break;
            //预发布环境环境
            case 'release':

                //TODO : 整理线上预发布第三方代理链接，与线上正是环境一致，如：七牛等其他OSS

                break;
            default:

                //TODO : 默认其他处理

                break;
        }
        //添加固定版本号
        $path .= ($version ? ((str_contains($path, '?') ? "&" : "?") . "v=" . config('builder.app_version')) : '');
        //整理信息
        return $path;
    }
}


// 其他项目自定义辅助函数
