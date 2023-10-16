<?php

namespace Abnermouke\Supports\Builders\Table\Items;

use Abnermouke\Supports\Frameworks\Laravel\Modules\BaseModel;

/**
 * 进展内容元素构建器
 */
class Schedules extends Builder
{

    /**
     * 构造函数
     * @param $field
     */
    public function __construct($field)
    {
        //引入父级
        parent::__construct('schedules', $field);
        //设置基本信息
        $this->on()->off()->verify()->fail()->delete();
    }

    /**
     * 设置启用时模版与参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-07-19 12:24:08
     * @param $value
     * @param $template
     * @return Schedules
     */
    public function on($value = BaseModel::STATUS_ENABLED, $template = '正常启用')
    {
        //设置启用时模版与参数
        return $this->setExtra('on', compact('value', 'template'));
    }

    /**
     * 设置禁用时模版与参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-07-19 12:24:28
     * @param $value
     * @param $template
     * @return Schedules
     */
    public function off($value = BaseModel::STATUS_DISABLED, $template = '已禁用')
    {
        //设置禁用时模版与参数
        return $this->setExtra('off', compact('value', 'template'));
    }

    /**
     * 设置审核时模版与参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-07-19 12:24:36
     * @param $value
     * @param $template
     * @return Schedules
     */
    public function verify($value = BaseModel::STATUS_VERIFYING, $template = '审核中')
    {
        //设置禁用时模版与参数
        return $this->setExtra('verify', compact('value', 'template'));
    }

    /**
     * 设置审核失败用时模版与参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-07-19 12:24:45
     * @param $value
     * @param $template
     * @return Schedules
     */
    public function fail($value = BaseModel::STATUS_VERIFY_FAILED, $template = '审核失败')
    {
        //设置失败用时模版与参数
        return $this->setExtra('fail', compact('value', 'template'));
    }

    /**
     * 设置删除时模版与参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-07-19 12:25:08
     * @param $value
     * @param $template
     * @return Schedules
     */
    public function delete($value = BaseModel::STATUS_DELETED, $template = '已删除')
    {
        //设置失败用时模版与参数
        return $this->setExtra('delete', compact('value', 'template'));
    }


}
