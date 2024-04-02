<?php

namespace Abnermouke\Supports\Builders\Form\Items;

/**
 * 表单内容元素构建器
 */
class Builder
{

    //构建器默认数据
    protected $builder = [];

    /**
     * 构造函数
     * @param $type
     * @param $field
     * @param $label
     */
    public function __construct($type, $field, $label)
    {
        //设置默认信息
        $this->set('type', $type)->set('field', $field)->label($label)->required(false)->tips()->tip()->set('extras', [])->disabled(false);
    }

    /**
     * 设置必填
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 10:02:06
     * @param $required
     * @return $this
     */
    public function required($required = true)
    {
        //设置必填
        return $this->set('required', $required);
    }

    /**
     * 设置内容提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 10:01:29
     * @param $tips
     * @return $this
     */
    public function tips($tips = [])
    {
        //设置内容提示
        return $this->set('tips', $tips);
    }

    /**
     * 追加内容提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-23 15:53:20
     * @param $tip
     * @return $this
     */
    protected function mergeTips($tip)
    {
        //判断信息
        if ($tip) {
            //追加信息
            $this->builder['tips'][] = $tip;
        }
        //返回当前实例
        return $this;
    }

    /**
     * 设置简要提示（区分于tips）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 09:58:12
     * @param $desc
     * @return $this
     */
    public function tip($desc = '')
    {
        //设置内容描述
        return $this->set('tip', $desc);
    }

    /**
     * 设置内容名称
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 09:57:17
     * @param $label
     * @return $this
     */
    public function label($label)
    {
        //设置内容名称
        return $this->set('label', $label);
    }

    /**
     * 设置内容不可用
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 10:14:19
     * @param $disabled
     * @return $this
     */
    public function disabled($disabled = true)
    {
        //设置内容不可用
        return $this->set('disabled', $disabled);
    }

    /**
     * 设置构建器参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 09:55:57
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
     * @Time 2023-09-21 09:55:51
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
     * @Time 2023-09-21 09:55:46
     * @return array|mixed
     */
    public function get()
    {
        //返回构建器内容
        return $this->builder;
    }

}
