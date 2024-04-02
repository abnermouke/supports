<?php

namespace Abnermouke\Supports;

use Abnermouke\Supports\Assists\File;
use Abnermouke\Supports\Assists\Path;

/**
 * abnermouke/supports 扩展包触发事件类
 */
class AbnermoukeSupportsEvents
{

    /**
     * 扩展包被加载时触发
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-23 01:40:57
     * @return bool
     */
    public static function autoload()
    {
        //判断文件是否存在
        if (File::missing(($target_path = Path::public('static/avatars')))) {
            //检查路径
            File::makeDirectory($target_path, 0755, true);
            //查询全部文件
            foreach (($files = File::files(Path::vendor('abnermouke/supports/data/avatars'))) as $k => $file) {
                //复制文件
                File::copy($file['path'], $target_path.'/'.$file['basename']);
                //释放内存
                unset($files[$k], $file);
            }
        }
        //设置执行完毕
        return true;
    }

}
