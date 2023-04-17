<?php

namespace Abnermouke\Supports\Library;

/**
 * 验证方法藏类
 */
class ValidateLibrary
{

    /**
     * 邮箱号码验证
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:52:42
     * @param $email string 邮箱号码
     * @return bool|string
     * @throws \Exception
     */
    public static function email($email)
    {
        //验证规则
        $regular = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/';
        //返回验证结果
        return  self::validate($regular, $email);
    }

    /**
     * 有效链接地址验证
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:53:26
     * @param $link string 访问链接
     * @return bool|string
     * @throws \Exception
     */
    public static function link($link)
    {
        //验证规则
        $regular = '/[a-zA-z]+:\/\/[^\s]*/i';
        //返回验证结果
        return  self::validate($regular, $link);
    }

    /**
     * 有效IP验证（IPV4）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:53:42
     * @param $ip string IP地址
     * @return bool|string
     * @throws \Exception
     */
    public static function ip($ip)
    {
        //验证规则
        $regular = '/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/';
        //返回验证结果
        return  self::validate($regular, $ip);
    }

    /**
     * 有效QQ号码验证
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:53:53
     * @param $qq string QQ号码
     * @return bool|string
     * @throws \Exception
     */
    public static function qq($qq)
    {
        //验证规则
        $regular = '/^[1-9][0-9]{4,}$/';
        //返回验证结果
        return  self::validate($regular, $qq);
    }

    /**
     * 身份证号码（中国大陆）验证
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:54:07
     * @param $id_card string 身份证号码
     * @return bool|string
     * @throws \Exception
     */
    public static function idCard($id_card)
    {
        //验证规则
        $regular = '/^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/';
        //返回验证结果
        return  self::validate($regular, $id_card);
    }

    /**
     * 银行卡号验证
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:54:19
     * @param $bank_card string 银行卡号
     * @return bool|string
     * @throws \Exception
     */
    public static function bankCard($bank_card)
    {
        //验证规则
        $regular = '/^(\d{16}|\d{19}|\d{17})$/';
        //返回验证结果
        return  self::validate($regular, $bank_card);
    }

    /**
     * 手机号码验证
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:54:31
     * @param $mobile string 手机号码
     * @return bool|string
     * @throws \Exception
     */
    public static function mobile($mobile)
    {
        //验证规则
        $regular = '/^1[3456789]\d{9}$/';
        //返回验证结果
        return  self::validate($regular, $mobile);
    }

    /**
     * 固定电话验证
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:54:42
     * @param $tel string 固定电话
     * @return bool|string
     * @throws \Exception
     */
    public static function tel($tel)
    {
        //验证规则
        $regular = '/^([0-9]{3,4}-)?[0-9]{7,8}$/';
        //返回验证结果
        return  self::validate($regular, $tel);
    }

    /**
     * 只包含中文验证
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:54:52
     * @param $string string 验证文案
     * @return bool|string
     * @throws \Exception
     */
    public static function onlyZh($string)
    {
        //验证规则
        $regular = '/^[\x{4e00}-\x{9fa5}]+$/u';
        //返回验证结果
        return self::validate($regular, $string);
    }

    /**
     * 包含中文验证
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:55:02
     * @param $string string 验证文案
     * @return bool|string
     * @throws \Exception
     */
    public static function hasZh($string)
    {
        //验证规则
        $regular = '/[\x{4e00}-\x{9fa5}]/u';
        //返回验证结果
        return self::validate($regular, $string);
    }

    /**
     * 判断是否包含html
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:55:13
     * @param $string string 验证文案
     * @return bool
     */
    public static function hasHtml($string)
    {
        //判断是否包含html
        if ($string !== strip_tags($string)) {
            //返回验证结果
            return true;
        }
        //返回验证结果
        return false;
    }

    /**
     * 判断是否为微信浏览器
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:55:30
     * @param $ua string 访问UA
     * @return bool
     */
    public static function wechatBroswer($ua)
    {
        //判断是否为微信浏览器
        if (strpos($ua, 'MicroMessenger') !== false) {
            //返回验证结果
            return true;
        }
        //返回验证结果
        return false;
    }

    /**
     * 自定义验证（正则匹配）信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:55:42
     * @param $regular string 验证（正则匹配）规则
     * @param $string string 验证|匹配文案
     * @return false|mixed
     */
    private static function validate($regular, $string)
    {
        //正则匹配
        $ret = preg_match($regular, $string, $matched);
        //验证成功
        if ($ret >= 1) {
            //返回字符串
            return $string;
        }
        //返回失败
        return false;
    }

}
