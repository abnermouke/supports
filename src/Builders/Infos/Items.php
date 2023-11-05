<?php

namespace Abnermouke\Supports\Builders\Infos;

use Abnermouke\Supports\Builders\Infos\Items\Images;
use Abnermouke\Supports\Builders\Infos\Items\Options;
use Abnermouke\Supports\Builders\Infos\Items\Text;
use Abnermouke\Supports\Frameworks\Laravel\Modules\BaseModel;

/**
 * 展示内容构建器
 */
class Items
{

    //整理默认构建数据
    private $contents = [];


    /**
     * 创建文本实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-05 22:12:00
     * @param $field
     * @param $name
     * @return Text
     */
    public function text($field, $name = '')
    {
        //创建构建信息
        $this->contents[] = $builder = new Text($field, $name);
        //返回构建实例
        return $builder;
    }

    /**
     * 创建选项实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-05 22:12:34
     * @param $field
     * @param $name
     * @return Options
     */
    public function options($field, $name = '')
    {
        //创建构建信息
        $this->contents[] = $builder = new Options($field, $name);
        //返回构建实例
        return $builder;
    }

    /**
     * 构建图片实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-05 22:12:40
     * @param $field
     * @param $name
     * @return Images
     */
    public function images($field, $name = '')
    {
        //创建构建信息
        $this->contents[] = $builder = new Images($field, $name);
        //返回构建实例
        return $builder;
    }

    /**
     * 返回当前构建信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-03 14:24:39
     * @return mixed
     */
    public function get()
    {
        //返回当前构建信息
        return $this->contents;
    }

}
