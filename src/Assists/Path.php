<?php

namespace Abnermouke\Supports\Assists;

/**
 * 地址模块方法集合
 */
class Path
{

    /**
     * 获取项目路径
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:35:18
     * @param $dictionary string 项目路径目录名称
     * @return string
     */
    public static function root($dictionary = '')
    {
        //替换信息
        $root_path = str_replace(('vendor'.DIRECTORY_SEPARATOR.'abnermouke'.DIRECTORY_SEPARATOR.'supports'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Assists'), '', __DIR__);
        //返回目录
        return $root_path.$dictionary;
    }

    /**
     * 获取APP路径
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:33:30
     * @param $path
     * @return string
     */
    public static function app($path = '')
    {
        //返回地址
        return static::target('app', $path);
    }

    /**
     * 获取public路径
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:33:30
     * @param $path
     * @return string
     */
    public static function public($path = '')
    {
        //返回地址
        return static::target('public', $path);
    }


    /**
     * 获取vendor路径
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:33:30
     * @param $path
     * @return string
     */
    public static function vendor($path = '')
    {
        //返回地址
        return static::target('vendor', $path);
    }

    /**
     * 获取指定目录
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:44:48
     * @param $root_dictionary
     * @param $path
     * @return string
     */
    public static function target($root_dictionary, $path = '')
    {
        //获取根目录
        $root_path = static::root($root_dictionary);
        //判断是否追加路径
        if ($path && (($path = static::formatPath($path)) !== DIRECTORY_SEPARATOR)) {
            //追加地址
            $root_path .= DIRECTORY_SEPARATOR.$path;
        }
        //返回地址
        return $root_path;
    }

    /**
     * 获取日志记录目录
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 17:36:26
     * @param $mkdir bool 是否自动创建目录
     * @param $mode int 权限编码
     * @return string
     */
    public static function logger($mkdir = true, $mode = 0755)
    {
        //判断框架
        if (Framework::laravel()) {
            //整理路径
            $path = self::target('storage', 'logs/logger');
        } elseif (Framework::thinkphp()) {
            //整理路径
            $path = self::target('runtime', 'logger');
        } elseif (Framework::hyperf()) {
            //整理路径
            $path = self::target('runtime', 'logger');
        } else {
            //整理路径
            $path = self::target('logger');
        }
        //判断是否创建目录
        if ($mkdir && !File::isDirectory($path)) {
            //创建目录
            File::makeDirectory($path, $mode, true);
        }
        //返回路径
        return $path;
    }

    /**
     * 格式化路径
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:37:10
     * @param $path string 路径
     * @return array|string|string[]
     */
    public static function formatPath($path)
    {
        //整理信息
        return $path ? str_replace(['/', '\''], DIRECTORY_SEPARATOR, $path) : '';
    }

}
