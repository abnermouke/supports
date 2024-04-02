<?php

namespace Abnermouke\Supports\Library;

use Abnermouke\Supports\Assists\File;
use Abnermouke\Supports\Assists\Framework;
use Abnermouke\Supports\Assists\Path;

/**
 * 日志记录藏库
 */
class LoggerLibrary
{

    //日志记录目录
    private static $loggerPath;

    /**
     * 创建日志目录
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 17:52:57
     */
    private static function create()
    {
        //初始化目录
        static::$loggerPath = Path::logger();
    }

    /**
     * 记录日志
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 17:52:45
     * @param $alias string 识别标识
     * @param $content mixed 记录内容 json|array|string|mixed
     * @param $logger_path string 自定义目录
     * @return bool
     */
    public static function record($alias, $content, $logger_path = '')
    {
        //初始化目录
        static::create();
        //初始化路径
        $path = static::$loggerPath.DIRECTORY_SEPARATOR.($logger_path ? Path::formatPath($logger_path) : (str_replace([' ', ':'], DIRECTORY_SEPARATOR, strtolower($alias)).DIRECTORY_SEPARATOR.date('Y-m-d').'.log'));
        //获取文件目录
        if (File::missing($path)) {
            //判断目录
            if (!File::isDirectory(($directory = File::dirname($path)))) {
                //创建目录
                File::makeDirectory($directory, 0755, true);
            }
            //写入文件
            File::put($path, self::contents('SYSTEM', '创建日志记录文件'));
        }
        //追加文件内容
        File::append($path, self::contents($alias, $content));
        //返回成功
        return true;
    }

    /**
     * 设置文件内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 17:51:27
     * @param $alias
     * @param $content
     * @return string
     */
    private static function contents($alias, $content)
    {
        //整理基础结构
        $contents = [];
        //生成唯一编码
        $sn = HelperLibrary::createSn();
        //追加内容
        $contents[] = "============================ BEGIN ".$sn." =========================";
        //设置内容
        $contents[] = HelperLibrary::formatDateTime()." [".strtoupper($alias)."]  ".(is_array($content) ? json_encode($content, JSON_UNESCAPED_UNICODE) : $content);
        //设置结束
        $contents[] = "============================ END ".$sn." ===========================";
        //追加换行符
        $contents[] = "\n";
        //返回信息
        return implode("\n\n", $contents);
    }

}
