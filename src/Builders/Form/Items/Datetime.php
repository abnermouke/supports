<?php

namespace Abnermouke\Supports\Builders\Form\Items;
/**
 * 日期内容元素构建器
 */
class Datetime extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $label
     */
    public function __construct($field, $label)
    {
        //引入父级构造
        parent::__construct('datetime', $field, $label);
        //设置默认参数
        $this->placeholder('点击选择'.$label)->setExtra('pickerType', 'datetime')->separator()->range(false)->hideSecond(false)->start()->end()->setExtra('pickerValue', '');
    }

    /**
     * 设置区间分隔符
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-26 16:15:53
     * @param $separator
     * @return Datetime|m.\Abnermouke\Supports\Builders\Form\Items\Datetime.setExtra
     */
    public function separator($separator = ' 至 ') {
        //设置区间分隔符
        return $this->setExtra('separator', $separator);
    }

    /**
     * 设置文本框占位符
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 10:10:06
     * @param $placeholder
     * @return Datetime
     */
    public function placeholder($placeholder = '点击选择日期/时间')
    {
        //设置文本框占位符
        return $this->setExtra('placeholder', $placeholder);
    }

    /**
     * 设置为仅选日期
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:14:46
     * @return Datetime
     */
    public function onlyDate()
    {
        //设置为仅选日期
        return $this->setExtra('pickerType', 'date')->range($this->builder['extras']['range']);
    }

    /**
     * 设置为区间选择
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:14:54
     * @param $range
     * @param $separator
     * @return Datetime
     */
    public function range($range = true)
    {
        //判断是否区间选择
        $range && $this->setExtra('pickerType', $this->builder['extras']['pickerType'].'range');
        //设置为区间选择
        return $this->setExtra('range', $range);
    }

    /**
     * 设置是否隐藏秒
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:15:27
     * @param $hide
     * @return Datetime
     */
    public function hideSecond($hide = true)
    {
        //设置是否隐藏秒
        return $this->setExtra('hideSecond', $hide);
    }

    /**
     * 设置最小日期
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:15:31
     * @param $datetime
     * @param $text
     * @return Datetime
     */
    public function start($datetime = '1970-01-01 00:00:00', $text = '开始时间')
    {
        //设置最小日期
        return $this->setExtra('start', $datetime)->setExtra('startPlaceholder', $text);
    }

    /**
     * 设置最大日期
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:15:37
     * @param $datetime
     * @param $text
     * @return Datetime
     */
    public function end($datetime = '', $text = '结束时间')
    {
        //设置最大日期
        return $this->setExtra('end', $datetime)->setExtra('endPlaceholder', $text);
    }

}
