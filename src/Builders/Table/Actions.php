<?php

namespace Abnermouke\Supports\Builders\Table;

use Abnermouke\Supports\Builders\Route\Interfaces;
use Abnermouke\Supports\Builders\Route\Navigate;

/**
 * 表格操作构建器
 */
class Actions
{

    //整理默认构建数据
    private $contents = [];
    //整理默认构建条件
    private $conditions = [];

    /**
     * 创建路由跳转实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 14:18:18
     * @param $name
     * @param $conditions array  ['{field}', 'in|not-in', [1, 2, 3]]
     * @return Navigate
     */
    public function navigate($name, $conditions = [])
    {
        //创建构建器
        $this->conditions[] = $conditions;
        $this->contents[] = $builder = new Navigate($name);
        //返回实例对象
        return $builder;
    }

    /**
     * 创建接口请求实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 14:18:24
     * @param $name
     * @param $conditions array ['{field}', 'in|not-in', [1, 2, 3]]
     * @return Interfaces
     */
    public function interface($name, $conditions = [])
    {
        //创建构建器
        $this->conditions[] = $conditions && $conditions[2] ? $conditions : [];
        $this->contents[] = $builder = new Interfaces($name);
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
        //判断内容信息
        if ($this->contents) {
            //循环内容
            foreach ($this->contents as $k => $content) {
                //判断信息
                if ($content instanceof Interfaces || $content instanceof Navigate) {
                    //获取内容
                    $content = $content->get();
                }
                //设置条件
                $content['conditions'] = $this->conditions[$k];
                //设置信息
                $this->contents[$k] = $content;
            }
        }
        //返回构建器信息
        return ['enable' => !empty($this->contents), 'contents' => $this->contents];
    }

}
