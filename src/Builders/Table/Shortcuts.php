<?php

namespace Abnermouke\Supports\Builders\Table;

use Abnermouke\Supports\Frameworks\Laravel\Modules\BaseModel;

/**
 * 表格快速操作构建器
 */
class Shortcuts
{

    //整理默认构建数据
    private $contents = [];


    /**
     * 创建快速操作
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 01:02:12
     * @param $field
     * @param $label
     * @param $post_url
     * @param $row_fields
     * @param $on
     */
    public function create($field, $label, $post_url, $row_fields = [], $on = BaseModel::SWITCH_ON, $refresh = true)
    {
        //初始化信息
        $url = $post_url;
        //设置信息
        $this->contents[] = compact('field', 'label', 'url', 'row_fields', 'on', 'refresh');
    }

    /**
     * 获取构建器配置信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 01:02:55
     * @return array
     */
     public function get()
    {
        //返回数据
        return ['enable' => !empty($this->contents), 'contents' => $this->contents];
    }

}
