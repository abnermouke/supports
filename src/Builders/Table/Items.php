<?php

namespace Abnermouke\Supports\Builders\Table;

use Abnermouke\Supports\Builders\Table\Items\Cover;
use Abnermouke\Supports\Builders\Table\Items\Desc;
use Abnermouke\Supports\Builders\Table\Items\Header;
use Abnermouke\Supports\Builders\Table\Items\Infos;
use Abnermouke\Supports\Builders\Table\Items\Mark;
use Abnermouke\Supports\Builders\Table\Items\Schedules;
use Abnermouke\Supports\Builders\Table\Items\Tags;
use Abnermouke\Supports\Builders\Table\Items\Title;

/**
 * 表格内容元素构建器
 */
class Items
{


    //整理默认构建数据
    private $contents = [];

    /**
     * 创建标题对象
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:54:33
     * @param $field
     * @return Title
     */
    public function title($field)
    {
        //创建实例
        $this->contents[] = $builder = new Title($field);
        //返回实例对象
        return $builder;
    }

    /**
     * 创建描述对象
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:54:42
     * @param $field
     * @return Desc
     */
    public function desc($field)
    {
        //创建实例
        $this->contents[] = $builder = new Desc($field);
        //返回实例对象
        return $builder;
    }

    /**
     * 创建封面图对象
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:54:58
     * @param $field
     * @return Cover
     */
    public function cover($field)
    {
        //创建实例
        $this->contents[] = $builder = new Cover($field);
        //返回实例对象
        return $builder;
    }

    /**
     * 创建进展对象
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:55:11
     * @param $field
     * @return Schedules
     */
    public function schedule($field)
    {
        //创建实例
        $this->contents[] = $builder = new Schedules($field);
        //返回实例对象
        return $builder;
    }

    /**
     * 创建标签对象
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:55:22
     * @param $field
     * @return Tags
     */
    public function tags($field)
    {
        //创建实例
        $this->contents[] = $builder = new Tags($field);
        //返回实例对象
        return $builder;
    }

    /**
     * 创建详细内容对象
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:55:29
     * @param $field
     * @return Infos
     */
    public function info($field)
    {
        //创建实例
        $this->contents[] = $builder = new Infos($field);
        //返回实例对象
        return $builder;
    }

    /**
     * 创建标记对象
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:55:39
     * @param $field
     * @return Mark
     */
    public function mark($field)
    {
        //创建实例
        $this->contents[] = $builder = new Mark($field);
        //返回实例对象
        return $builder;
    }

    /**
     * 创建头部对象
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-10-30 16:01:02
     * @param $field
     * @return Header
     */
    public function header($field)
    {
        //创建实例
        $this->contents[] = $builder = new Header($field);
        //返回实例对象
        return $builder;
    }

    /**
     * 获取构建器信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:17:07
     * @return array
     */
    public function get()
    {
        //返回构建器信息
        return ['enable' => !empty($this->contents), 'contents' => $this->contents];
    }

}
