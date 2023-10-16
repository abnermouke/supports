<?php

namespace Abnermouke\Supports\Builders\Form\Items;

/**
 * 文本框内容元素构建器
 */
class Input extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $label
     */
    public function __construct($field, $label)
    {
        //引入父级构造
        parent::__construct('input', $field, $label);
        //设置默认参数
        $this->colomn()->input_type()->placeholder('请输入'.$label)->suffix()->maxlength()->clipboard(false);
    }

    /**
     * 设置排列方向 - 纵向
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-22 16:05:30
     * @return Input
     */
    public function colomn()
    {
        //设置排列方向
        return $this->setExtra('direction', 'column');
    }

    /**
     * 设置排列方向 - 横向
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-22 16:05:23
     * @return Input
     */
    public function row()
    {
        //设置排列方向
        return $this->setExtra('direction', 'row');
    }

    /**
     * 设置文本框类型
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 10:08:27
     * @param $type
     * @return Input
     */
    public function input_type($type = 'text')
    {
        //初始化信息
        $modes = ['text' => 'text', 'number' => 'numeric', 'idcard' => 'text', 'digit' => 'decimal', 'tel' => 'tel'];
        //设置文本框类型
        return $this->setExtra('inputType', $type)->input_mode(data_get($modes, $type, 'text'));
    }

    /**
     * 设置文本框占位符
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 10:10:06
     * @param $placeholder
     * @return Input
     */
    public function placeholder($placeholder = '')
    {
        //设置文本框占位符
        return $this->setExtra('placeholder', $placeholder);
    }

    /**
     * 设置文本框后缀提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 10:11:18
     * @param $text
     * @return Input
     */
    public function suffix($text = '')
    {
        //设置文本框后缀提示
        return $this->setExtra('suffix', $text);
    }

    /**
     * 设置限制录入最大长度
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 10:12:33
     * @param $length
     * @return Input
     */
    public function maxlength($length = -1)
    {
        //设置限制录入最大长度
        return $this->setExtra('maxlength', $length);
    }

    /**
     * 设置文本框数据类型
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:05:52
     * @param $mode
     * @return Input
     */
    public function input_mode($mode = 'text')
    {
        //设置文本框数据类型
        return $this->setExtra('inputMode', $mode);
    }

    /**
     * 设置复制信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:32:29
     * @param $clipboard
     * @return Input
     */
    public function clipboard($clipboard = true)
    {
        //设置复制信息
        return $this->setExtra('clipboard', $clipboard);
    }


}
