<?php

namespace Abnermouke\Supports\Builders\Table;

use Abnermouke\Supports\Builders\Table\Filters\Datetime;
use Abnermouke\Supports\Builders\Table\Filters\Input;
use Abnermouke\Supports\Builders\Table\Filters\Location;
use Abnermouke\Supports\Builders\Table\Filters\Options;
use Abnermouke\Supports\Builders\Table\Filters\Range;

/**
 * 表格筛选构建器
 */
class Filters
{

    //整理默认构建数据
    private $contents = [];

    /**
     * 输入框筛选
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:24:17
     * @param $field
     * @param $name
     * @return Input
     */
    public function input($field, $name)
    {
        //生成构建对象
        $this->contents[] = $builder = new Input($field, $name);
        //返回实例对象
        return $builder;
    }

    /**
     * 选项筛选
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:24:44
     * @param $field
     * @param $name
     * @return Options
     */
    public function opotions($field, $name)
    {
        //生成构建对象
        $this->contents[] = $builder = new Options($field, $name);
        //返回实例对象
        return $builder;
    }

    /**
     * 数值区间筛选
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:24:50
     * @param $field
     * @param $name
     * @return Range
     */
    public function range($field, $name)
    {
        //生成构建对象
        $this->contents[] = $builder = new Range($field, $name);
        //返回实例对象
        return $builder;
    }

    /**
     * 定位筛选
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:24:58
     * @param $field
     * @param $name
     * @return Location
     */
    public function location($field, $name)
    {
        //生成构建对象
        $this->contents[] = $builder = new Location($field, $name);
        //返回实例对象
        return $builder;
    }

    /**
     * 日期/时间筛选
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:25:05
     * @param $field
     * @param $name
     * @return Datetime
     */
    public function datetime($field, $name)
    {
        //生成构建对象
        $this->contents[] = $builder = new Datetime($field, $name);
        //返回实例对象
        return $builder;
    }

    /**
     * 获取筛选构建配置
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:22:44
     * @return array
     */
    public function get()
    {
        //返回数据
        return ['enable' => !empty($this->contents), 'contents' => $this->contents];
    }

}
