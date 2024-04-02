<?php

namespace Abnermouke\Supports\Library;

use Abnermouke\Supports\Assists\File;
use SimpleSoftwareIO\QrCode\Generator;

/**
 * 二维码藏库
 */
class QrLibrary
{

    /**
     * 创建二维码
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 21:40:27
     * @param $content string 二维码内容
     * @param $path string 文件路径
     * @param $size int 等比大小
     * @param $force_merge bool 是否强制覆盖
     * @return mixed
     */
    public static function create($content, $path, $size = 200, $force_merge = false)
    {
        //检查目录情况
        File::checkDictionary($path);
        //判断文件是否存在
        if (!File::exists($path) || $force_merge) {
            //生成实例
            $handler = new Generator();
            //创建二维码
            $handler->format('png')->size((int)$size)->encoding('UTF-8')->generate($content, $path);
        }
        //返回地址信息
        return $path;
    }


}
