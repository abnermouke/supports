<?php

namespace Abnermouke\Supports\Builders;

use Abnermouke\Supports\Frameworks\Laravel\Modules\BaseModel;
use Abnermouke\Supports\Assists\Arr;

/**
 * 主题构建器
 */
class ThemeBuilder
{

    /**
     * 主题标识
     */
    public const THEME_OF_DEFAULT = 'default';
    public const THEME_OF_PRIMARY = 'primary';
    public const THEME_OF_SECONDARY = 'secondary';
    public const THEME_OF_SUCCESS = 'success';
    public const THEME_OF_INFO = 'info';
    public const THEME_OF_WARNING = 'warning';
    public const THEME_OF_DANGER = 'danger';
    public const THEME_OF_LIGHT = 'light';
    public const THEME_OF_DARK = 'dark';

    /**
     * 获取全部主题标识
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-06-20 01:59:03
     * @return string[]
     */
    public static function get()
    {
        //获取主题标识
        return [
            self::THEME_OF_DEFAULT,
            self::THEME_OF_PRIMARY,
            self::THEME_OF_SECONDARY,
            self::THEME_OF_SUCCESS,
            self::THEME_OF_INFO,
            self::THEME_OF_WARNING,
            self::THEME_OF_DANGER,
            self::THEME_OF_LIGHT,
            self::THEME_OF_DARK,
        ];
    }

    /**
     * 获取随机数量的主题标识
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-06-20 02:02:35
     * @param $length
     * @return array|mixed
     */
    public static function random($length = 1)
    {
        //获取随机数量的主题标识
        return Arr::first(Arr::random(self::get(), $length));
    }

    /**
     * 返回选择器主题标识
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-06-20 02:03:48
     * @return string[]
     */
    public static function switch()
    {
        //返回选择器主题标识
        return [BaseModel::SWITCH_ON => self::THEME_OF_SUCCESS, BaseModel::SWITCH_OFF => self::THEME_OF_DANGER];
    }

    /**
     * 返回状态主题标识
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-06-20 13:21:15
     * @param int $value
     * @return array|mixed|string[]
     */
    public static function status(int $value = 0)
    {
        //整理主题标识
        $aliases = [BaseModel::STATUS_ENABLED => self::THEME_OF_SUCCESS, BaseModel::STATUS_DISABLED => self::THEME_OF_WARNING, BaseModel::STATUS_VERIFYING => self::THEME_OF_PRIMARY, BaseModel::STATUS_VERIFY_FAILED => self::THEME_OF_DANGER, BaseModel::STATUS_DELETED => self::THEME_OF_DARK];
        //返回信息
        return $value > 0 ? data_get($aliases, $value, self::THEME_OF_DARK) : $aliases;
    }

}
