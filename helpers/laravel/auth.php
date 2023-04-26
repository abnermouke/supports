<?php
/**
 * Power by abnermouke/supports.
 * User: Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
 * Originate: YunniTec <https://www.yunnitec.com/>
 */


use Illuminate\Support\Facades\Session;

if (!function_exists('current_auth')) {
    /**
     * 获取当前session授权信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 14:42:26
     * @param $item
     * @param $prefix
     * @return array|false|mixed
     * @throws Exception
     */
    function current_auth($item = false, $prefix = 'your-project-alias:account')
    {
        //获取session信息
        if (!$auth = Session::get(auth_name($prefix), false)) {
            //返回失败
            return false;
        }
        //整理信息
        return $item && !empty($item) ? data_get($auth, $item, false) : $auth;
    }
}

if (!function_exists('set_current_auth')) {
    /**
     * 设置当前session认证信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 14:42:32
     * @param $auth
     * @param $prefix
     * @return null
     * @throws Exception
     */
    function set_current_auth($auth, $prefix = 'your-project-alias:account')
    {
        //设置session信息
        return Session::put(auth_name($prefix), $auth);
    }
}

if (!function_exists('auth_name')) {
    /**
     * 认证session名称
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 14:42:38
     * @param $prefix
     * @return string
     */
    function auth_name($prefix = 'your-project-alias:account')
    {
        //获取session授权名称
        return ($prefix && !empty($prefix) ? $prefix : 'your-project-alias:account').'_auth_info';
    }
}

if (!function_exists('auth_remove')) {
    /**
     * 删除session认证信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 14:42:43
     * @param $prefix
     * @param $clear_all
     * @return bool
     * @throws Exception
     */
    function auth_remove($prefix = 'your-project-alias:account', $clear_all = false)
    {
        //删除当前缓存
        Session::forget(auth_name($prefix));
        //判断是否删除全部
        Session::flush();
        //返回成功
        return true;
    }
}
