<?php

namespace Abnermouke\Supports\Builders\Table\Items;

/**
 * 表格内容元素构建器
 */
class Builder
{

    //构建器默认数据
    protected $builder = [];

    /**
     * 构造函数
     * @param $type
     * @param $field
     */
    public function __construct($type, $field)
    {
        //设置默认信息
        $this->set('type', $type)->set('field', $field)->template()->label()->bold(false)->theme(false)->invalid_placeholder();
    }

    /**
     * 显示模版
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-07-19 12:15:45
     * @param $template
     * @return $this
     */
    public function template($template = '')
    {
        //显示模版
        return $this->set('template', ($template ? $template : '{'.$this->builder['field'].'}'));
    }

    /**
     * 设置名称
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-04 19:07:27
     * @param $label
     * @return $this
     */
    public function label($label = '')
    {
        //显示模版
        return $this->set('label', $label);
    }

    /**
     * 设置是否加粗字体显示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-07-19 12:10:25
     * @param $bold
     * @return $this
     */
    public function bold($bold = true)
    {
        //设置是否加粗字体显示
        return $this->set('bold', $bold);
    }

    /**
     * 设置是否主题颜色显示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-07-19 12:11:22
     * @param $theme
     * @return $this
     */
    public function theme($theme = true)
    {
        //设置是否主题颜色显示
        return $this->set('theme', $theme);
    }

    /**
     * 设置参数无效时显示占位符
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-07-19 11:57:05
     * @param $placeholder
     * @return $this
     */
    public function invalid_placeholder($placeholder = '---')
    {
        //设置参数无效时显示占位符
        return $this->set('invalid_placeholder', $placeholder);
    }

    /**
     * 设置构建器参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 22:17:00
     * @param $key
     * @param $value
     * @return $this
     */
    protected function set($key, $value)
    {
        //设置信息
        data_set($this->builder, $key, $value);
        //返回当前实例
        return $this;
    }

    /**
     * 设置构建器额外参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 22:17:09
     * @param $key
     * @param $value
     * @return $this
     */
    public function setExtra($key, $value)
    {
        //设置信息
        data_set($this->builder, 'extras.'.$key, $value);
        //返回当前实例
        return $this;
    }

    /**
     * 获取构建器参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 22:17:15
     * @return array|mixed
     */
    public function get()
    {
        //返回构建器内容
        return $this->builder;
    }

}
