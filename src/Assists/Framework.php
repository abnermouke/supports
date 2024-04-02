<?php

namespace Abnermouke\Supports\Assists;

use Abnermouke\Supports\Library\HelperLibrary;

/**
 * 框架模块方法集合
 */
class Framework
{

    /**
     * 判断是否为thinkphp框架
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 17:30:21
     * @return bool
     */
    public static function thinkphp()
    {
        //判断是否存在thinkphp
        return self::check('topthink/think');
    }

    /**
     * 判断是否为laravel框架
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 17:31:09
     * @return bool
     */
    public static function laravel()
    {
        //判断是否存在laravel
        return self::check('laravel/laravel');
    }

    /**
     * 判断是否为hyperf框架
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 17:31:09
     * @return bool
     */
    public static function hyperf()
    {
        //判断是否存在laravel
        return self::check('hyperf/framework');
    }

    /**
     * 检测是否为指定框架
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 17:30:36
     * @param $package_name
     * @return bool
     */
    public static function check($package_name)
    {
        //获取composer内容
        $contents = self::getComposerJson();
        //判断是否存在内容
        if (data_get($contents, 'name', '') == $package_name) {
            //返回成功
            return true;
        }
        //判断目录
        $vendor_dictionaries = File::dictionaries(Path::vendor());
        //判断是否存在tp
        if ($vendor_dictionaries && in_array(Path::vendor(explode('/', $package_name)[0]), $vendor_dictionaries)) {
            //返回成功
            return true;
        }
        //返回失败
        return false;
    }

    /**
     * 获取根目录composer.json内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 17:28:32
     * @return array|mixed
     */
    private static function getComposerJson()
    {
        //获取根目录下composer.json
        $json_path = Path::root().'composer.json';
        //判断是否为文件
        if (File::exists($json_path) && File::isFile($json_path)) {
            //返回信息
            return HelperLibrary::objectToArray(file_get_contents($json_path));
        }
        //返回为空
        return [];
    }





}
