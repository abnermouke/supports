<?php

namespace Abnermouke\Supports\Library;

use DfaFilter\SensitiveHelper;

/**
 * 违禁词筛选藏库
 */
class SensitiveFilterLibrary
{

    /**
     * 实例对象处理器
     * @var SensitiveHelper
     */
    private static $handler;

    /**
     * 构造函数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 21:44:51
     * @param $filter_file_path bool|string 违禁词文件绝对路径
     * @throws \DfaFilter\Exceptions\PdsBusinessException
     */
    private static function load($filter_file_path = false)
    {
        //实例化处理对象
        self::$handler = SensitiveHelper::init()->setTreeByFile($filter_file_path ? $filter_file_path : __DIR__.'/../../data/forbidden_words.dic');
    }

    /**
     * 检测是否含有违禁词
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 21:45:48
     * @param $content_raw string 检测内容
     * @param $filter_file_path mixed 违禁词文件
     * @return bool
     * @throws \DfaFilter\Exceptions\PdsBusinessException
     * @throws \DfaFilter\Exceptions\PdsSystemException
     */
    public static function islegal($content_raw, $filter_file_path = false)
    {
        //加载违禁词文件
        self::load($filter_file_path);
        //检测是否含有敏感词
        return self::$handler->islegal($content_raw);
    }

    /**
     * 检测敏感词并将敏感词替换为指定文案
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 21:46:33
     * @param $content_raw string 检测内容
     * @param string $replace_content 替换文案
     * @param bool $repeat 是否替换为相同长度的文案
     * @param $filter_file_path mixed 违禁词文件
     * @return \DfaFilter\文本内容|mixed
     * @throws \DfaFilter\Exceptions\PdsBusinessException
     * @throws \DfaFilter\Exceptions\PdsSystemException
     */
    public static function replace($content_raw, $replace_content = '*', $repeat = true, $filter_file_path = false)
    {
        //加载违禁词文件
        self::load($filter_file_path);
        //检测是否含有敏感词
        return self::$handler->replace($content_raw, $replace_content, $repeat);
    }

    /**
     * 将检测内容中的违禁词使用指定标签标记
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 21:46:50
     * @param $content_raw string 检测内容
     * @param string $before 标签前缀
     * @param string $after 标签后缀
     * @param $filter_file_path mixed 违禁词文件
     * @return \DfaFilter\文本内容|mixed
     * @throws \DfaFilter\Exceptions\PdsBusinessException
     * @throws \DfaFilter\Exceptions\PdsSystemException
     */
    public static function mark($content_raw, $before = '<forbidden_word>', $after = '</forbidden_word>', $filter_file_path = false)
    {
        //加载违禁词文件
        self::load($filter_file_path);
        //检测是否含有敏感词
        return self::$handler->mark($content_raw, $before, $after);
    }

    /**
     * 获取检测内容中的违禁词
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 21:47:01
     * @param $content_raw string 检测内容
     * @param int $limit 获取自定个数
     * @param $filter_file_path mixed 违禁词文件
     * @return array
     * @throws \DfaFilter\Exceptions\PdsBusinessException
     * @throws \DfaFilter\Exceptions\PdsSystemException
     */
    public static function forbidden_word($content_raw, $limit = 0, $filter_file_path = false)
    {
        //加载违禁词文件
        self::load($filter_file_path);
        //检测是否含有敏感词
        return self::$handler->getBadWord($content_raw, 1, (int)$limit);
    }

}
