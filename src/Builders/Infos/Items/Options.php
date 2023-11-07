<?php

namespace Abnermouke\Supports\Builders\Infos\Items;

use Abnermouke\Supports\Frameworks\Laravel\Modules\BaseModel;

/**
 * 选项内容构建器
 */
class Options extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $name
     */
    public function __construct($field, $name)
    {
        //引入父级构造
        parent::__construct('options', $field, $name);
        //设置默认参数
        $this->themes();
    }

    /**
     * 设置选项
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-05 22:08:47
     * @param $options
     * @return Options
     */
    public function options($options = [])
    {
        //设置选项
        return $this->setExtra('options', $options);
    }

    /**
     * 设置选项对应主题
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-05 22:09:35
     * @param $themes
     * @return Options
     */
    public function themes($themes = [BaseModel::STATUS_ENABLED => 'primary', BaseModel::STATUS_DISABLED => 'danger', BaseModel::STATUS_VERIFYING => 'warning', BaseModel::STATUS_VERIFY_FAILED => 'info', BaseModel::STATUS_DELETED => 'danger'])
    {
        //设置选项对应主题
        return $this->setExtra('themes', $themes);
    }

}
