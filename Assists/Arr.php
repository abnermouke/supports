<?php

namespace Abnermouke\Supports\Assists;

use ArrayAccess;

/**
 * 数组模块方法集合
 */
class Arr
{
    /**
     * 生成请求参数结构
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:17:12
     * @param $array array 数组集合
     * @return string
     */
    public static function query($array)
    {
        return http_build_query($array, null, '&', PHP_QUERY_RFC3986);
    }

    /**
     * 排除数组指定内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:17:31
     * @param $array array 数组
     * @param $keys array|string 移除键值
     * @return mixed
     */
    public static function except($array, $keys)
    {
        static::forget($array, $keys);

        return $array;
    }

    /**
     * 获取数组指定内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:17:47
     * @param $array array 数组
     * @param $keys array|string 获取键值
     * @return array
     */
    public static function only($array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    /**
     * 在最前添加内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:18:34
     * @param $array array 数组
     * @param $value mixed 内容
     * @param $key string|mixed 指定键值
     * @return array|mixed
     */
    public static function prepend($array, $value, $key = null)
    {
        if (is_null($key)) {
            array_unshift($array, $value);
        } else {
            $array = [$key => $value] + $array;
        }

        return $array;
    }

    /**
     * 判断某个键值是否存在数组中
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:19:44
     * @param $array array 数组
     * @param $key mixed 键值
     * @return bool
     */
    public static function exists($array, $key)
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    }

    /**
     * 获取随机数量数组内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:48:51
     * @param $array array 数组
     * @param $number mixed 数量
     * @return array|mixed
     */
    public static function random($array, $number = null)
    {
        $requested = is_null($number) ? 1 : $number;

        $count = count($array);

        if ($requested > $count) {
            return $array;
        }

        if (is_null($number)) {
            return $array[array_rand($array)];
        }

        if ((int) $number === 0) {
            return [];
        }

        $keys = array_rand($array, $number);

        $results = [];

        foreach ((array) $keys as $key) {
            $results[] = $array[$key];
        }

        return $results;
    }

    /**
     * 移除数组某些内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:19:57
     * @param $array array 数组
     * @param $key mixed 键值
     */
    private static function forget(&$array, $keys)
    {
        $original = &$array;

        $keys = (array) $keys;

        if (count($keys) === 0) {
            return;
        }

        foreach ($keys as $key) {
            // if the exact key exists in the top-level, remove it
            if (static::exists($array, $key)) {
                unset($array[$key]);

                continue;
            }

            $parts = explode('.', $key);

            // clean up before each pass
            $array = &$original;

            while (count($parts) > 1) {
                $part = array_shift($parts);

                if (isset($array[$part]) && is_array($array[$part])) {
                    $array = &$array[$part];
                } else {
                    continue 2;
                }
            }

            unset($array[array_shift($parts)]);
        }
    }

    /**
     * 获取第一项
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:53:14
     * @param $array array 数组集合
     * @param $default mixed 默认返回数据
     * @return mixed|null
     */
    public static function first($array, $default = null)
    {
        if (empty($array)) {
            return $default;
        }

        foreach ($array as $item) {
            return $item;
        }

        return $default;
    }

    /**
     * 获取最后一项
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 14:54:19
     * @param $array array 数组集合
     * @param $default mixed 默认返回数据
     * @return false|mixed|null
     */
    public static function last($array, $default = null)
    {
        return empty($array) ? $default : end($array);
    }

}
