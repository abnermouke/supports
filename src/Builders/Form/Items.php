<?php

namespace Abnermouke\Supports\Builders\Form;

use Abnermouke\Supports\Builders\Form\Items\Album;
use Abnermouke\Supports\Builders\Form\Items\Attribute;
use Abnermouke\Supports\Builders\Form\Items\Datetime;
use Abnermouke\Supports\Builders\Form\Items\File;
use Abnermouke\Supports\Builders\Form\Items\Group;
use Abnermouke\Supports\Builders\Form\Items\Image;
use Abnermouke\Supports\Builders\Form\Items\Input;
use Abnermouke\Supports\Builders\Form\Items\Option;
use Abnermouke\Supports\Builders\Form\Items\Parameter;
use Abnermouke\Supports\Builders\Form\Items\Select;
use Abnermouke\Supports\Builders\Form\Items\Tags;
use Abnermouke\Supports\Builders\Form\Items\Textarea;
use Abnermouke\Supports\Builders\Form\Items\Video;

/**
 * 表单内容元素构建器
 */
class Items
{

    //整理默认构建数据
    private $contents = [];

    /**
     * 创建构建器实例 - 图册
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:05:47
     * @param $field
     * @param $label
     * @return Album
     */
    public function album($field, $label)
    {
        //创建构建器实例
        $this->contents[] = $builder = new Album($field, $label);
        //返回构建器
        return $builder;
    }

    /**
     * 创建构建器实例 - 属性
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:05:47
     * @param $field
     * @param $label
     * @return Attribute
     */
    public function attribute($field, $label)
    {
        //创建构建器实例
        $this->contents[] = $builder = new Attribute($field, $label);
        //返回构建器
        return $builder;
    }

    /**
     * 创建构建器实例 - 日期选择
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:05:47
     * @param $field
     * @param $label
     * @return Datetime
     */
    public function datetime($field, $label)
    {
        //创建构建器实例
        $this->contents[] = $builder = new Datetime($field, $label);
        //返回构建器
        return $builder;
    }

    /**
     * 创建构建器实例 - 文件上传
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:05:47
     * @param $field
     * @param $label
     * @return File
     */
    public function file($field, $label)
    {
        //创建构建器实例
        $this->contents[] = $builder = new File($field, $label);
        //返回构建器
        return $builder;
    }

    /**
     * 创建构建器实例 - 单图上传
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:05:47
     * @param $field
     * @param $label
     * @return Image
     */
    public function image($field, $label)
    {
        //创建构建器实例
        $this->contents[] = $builder = new Image($field, $label);
        //返回构建器
        return $builder;
    }

    /**
     * 创建构建器实例 - 文本框
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:05:47
     * @param $field
     * @param $label
     * @return Input
     */
    public function input($field, $label)
    {
        //创建构建器实例
        $this->contents[] = $builder = new Input($field, $label);
        //返回构建器
        return $builder;
    }

    /**
     * 创建构建器实例 - 选项
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:05:47
     * @param $field
     * @param $label
     * @return Option
     */
    public function option($field, $label)
    {
        //创建构建器实例
        $this->contents[] = $builder = new Option($field, $label);
        //返回构建器
        return $builder;
    }

    /**
     * 创建构建器实例 - 参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:05:47
     * @param $field
     * @param $label
     * @return Parameter
     */
    public function parameter($field, $label)
    {
        //创建构建器实例
        $this->contents[] = $builder = new Parameter($field, $label);
        //返回构建器
        return $builder;
    }

    /**
     * 创建构建器实例 - 选择框
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:05:47
     * @param $field
     * @param $label
     * @return Select
     */
    public function select($field, $label)
    {
        //创建构建器实例
        $this->contents[] = $builder = new Select($field, $label);
        //返回构建器
        return $builder;
    }

    /**
     * 创建构建器实例 - 标签
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:05:47
     * @param $field
     * @param $label
     * @return Tags
     */
    public function tags($field, $label)
    {
        //创建构建器实例
        $this->contents[] = $builder = new Tags($field, $label);
        //返回构建器
        return $builder;
    }

    /**
     * 创建构建器实例 - 文本域
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:05:47
     * @param $field
     * @param $label
     * @return Textarea
     */
    public function textarea($field, $label)
    {
        //创建构建器实例
        $this->contents[] = $builder = new Textarea($field, $label);
        //返回构建器
        return $builder;
    }

    /**
     * 创建构建器实例 - 视频上传
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:05:47
     * @param $field
     * @param $label
     * @return Video
     */
    public function video($field, $label)
    {
        //创建构建器实例
        $this->contents[] = $builder = new Video($field, $label);
        //返回构建器
        return $builder;
    }

    /**
     * 创建构建器实例 - 分组选项
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-10-30 22:18:20
     * @param $field
     * @param $label
     * @return Group
     */
    public function group($field, $label)
    {
        //创建构建器实例
        $this->contents[] = $builder = new Group($field, $label);
        //返回构建器
        return $builder;
    }

    /**
     * 获取构建器信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 09:54:18
     * @return array
     */
    public function get()
    {
        //返回构建器信息
        return ['enable' => !empty($this->contents), 'contents' => $this->contents];
    }

}
