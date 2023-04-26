<?php

namespace Abnermouke\Supports\Library;

/**
 * 设备方法藏类
 */
class DeviceLibrary
{
    /**
     * 是否为手机访问
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:08:58
     * @param $ua mixed 用户请求UA
     * @return bool
     */
    public static function mobile($ua = false)
    {
        //判断设备
        if (self::ipod($ua) || self::ipad($ua) || self::iphone($ua) || self::android($ua)) {
            //返回正确
            return true;
        }
        //返回错误
        return false;
    }

    /**
     * 是否为PC访问
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:09:04
     * @param $ua mixed 用户请求UA
     * @return bool
     */
    public static function pc($ua = false)
    {
        //判断设备
        if (self::windows($ua) || self::mac($ua) || self::unix($ua) || self::linux($ua)) {
            //返回正确
            return true;
        }
        //返回错误
        return false;
    }

    /**
     * 是否为windows设备访问
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:09:09
     * @param $ua mixed 用户请求UA
     * @return bool
     */
    public static function windows($ua = false)
    {
        //获取正确UA
        $agent = self::getUserAgent($ua);
        //判断是否为对应设备访问
        if (strpos($agent, 'windows nt')) {
            //返回正确
            return true;
        }
        //返回错误
        return false;
    }

    /**
     * 是否为unix设备访问
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:09:13
     * @param $ua mixed 用户请求UA
     * @return bool
     */
    public static function unix($ua = false)
    {
        //获取正确UA
        $agent = self::getUserAgent($ua);
        //判断是否为对应设备访问
        if (strpos($agent, 'unix')) {
            //返回正确
            return true;
        }
        //返回错误
        return false;
    }

    /**
     * 是否为linux设备访问
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:09:19
     * @param $ua mixed 用户请求UA
     * @return bool
     */
    public static function linux($ua = false)
    {
        //获取正确UA
        $agent = self::getUserAgent($ua);
        //判断是否为对应设备访问
        if (strpos($agent, 'linux')) {
            //返回正确
            return true;
        }
        //返回错误
        return false;
    }

    /**
     * 是否为mac设备访问
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:09:24
     * @param $ua mixed 用户请求UA
     * @return bool
     */
    public static function mac($ua = false)
    {
        //获取正确UA
        $agent = self::getUserAgent($ua);
        //判断是否为对应设备访问
        if (strpos($agent, 'macintosh')) {
            //返回正确
            return true;
        }
        //返回错误
        return false;
    }

    /**
     * 是否为ipod设备访问
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:09:29
     * @param $ua mixed 用户请求UA
     * @return bool
     */
    public static function ipod($ua = false)
    {
        //获取正确UA
        $agent = self::getUserAgent($ua);
        //判断是否为对应设备访问
        if (strpos($agent, 'ipod')) {
            //返回正确
            return true;
        }
        //返回错误
        return false;
    }

    /**
     * 是否为ipad设备访问
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:09:34
     * @param $ua mixed 用户请求UA
     * @return bool
     */
    public static function ipad($ua = false)
    {
        //获取正确UA
        $agent = self::getUserAgent($ua);
        //判断是否为对应设备访问
        if (strpos($agent, 'ipad')) {
            //返回正确
            return true;
        }
        //返回错误
        return false;
    }

    /**
     * 是否为iphone设备访问
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:09:39
     * @param $ua mixed 用户请求UA
     * @return bool
     */
    public static function iphone($ua = false)
    {
        //获取正确UA
        $agent = self::getUserAgent($ua);
        //判断是否为对应设备访问
        if (strpos($agent, 'iphone')) {
            //返回正确
            return true;
        }
        //返回错误
        return false;
    }

    /**
     * 是否为android设备访问
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:09:45
     * @param $ua mixed 用户请求UA
     * @return bool
     */
    public static function android($ua = false)
    {
        //获取正确UA
        $agent = self::getUserAgent($ua);
        //判断是否为对应设备访问
        if (strpos($agent, 'android')) {
            //返回正确
            return true;
        }
        //返回错误
        return false;
    }

    /**
     * 初始化实际UA
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-03-17 03:16:59
     * @param $ua mixed 用户请求UA
     * @return mixed|string|null
     */
    private static function getUserAgent($ua = false)
    {
        //判断是否设置UA
        return strtolower($ua ? $ua : $_SERVER["HTTP_USER_AGENT"]);
    }

}
