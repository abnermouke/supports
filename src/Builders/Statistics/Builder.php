<?php

namespace Abnermouke\Supports\Builders\Statistics;

/**
 * 信息统计构建器
 */
class Builder
{

    //整理默认构建数据
    private $contents = [];

    /**
     * 创建新的统计构建器
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:14:53
     * @param $value
     * @param $name
     * @return StatisticsBuilder
     */
    public function create($value, $name = '')
    {
        //创建统计信息
        $this->contents[] = $builder = new StatisticsBuilder($value, $name);
        //返回构建器
        return $builder;
    }

    /**
     * 获取构建器数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:15:18
     * @return array
     */
    public function get()
    {
        //返回信息
        return ['enable' => !empty($this->contents), 'contents' => $this->contents];
    }

}
