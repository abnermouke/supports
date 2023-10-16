<?php

namespace Abnermouke\Supports\Builders\Table\Filters;

/**
 * 时间筛选构建器
 */
class Datetime extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $name
     */
    public function __construct($field, $name)
    {
        //引入父级构造
        parent::__construct('datetime', $field, $name);
        //设置默认构建器参数
        $this->hideSecond(false)->start()->end()->range(false)->placeholder('点击选择'.$name)->setExtra('value', '')->separator();
    }

    /**
     * 设置区间分隔符
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-20 20:07:50
     * @param $separator
     * @return Datetime
     */
    public function separator($separator = ' 至 ') {
        //设置区间分隔符
        return $this->setExtra('separator', $separator);
    }

    /**
     * 设置默认占位符
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:16:48
     * @param $placeholder
     * @return Datetime
     */
    public function placeholder($placeholder = '点击选择日期/时间')
    {
        //设置默认占位符
        return $this->setExtra('placeholder', $placeholder);
    }

    /**
     * 设置最小日期
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:12:01
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
     * @Time 2023-09-19 00:11:56
     * @param $datetime
     * @param $text
     * @return Datetime
     */
    public function end($datetime = '', $text = '结束时间')
    {
        //设置最大日期
        return $this->setExtra('end', $datetime)->setExtra('endPlaceholder', $text);
    }

    /**
     * 设置为只选择日期
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:13:45
     * @param $range
     * @return Datetime
     */
    public function onlyDate($range = false)
    {
        //设置为只选择日期
        return $this->set('type', ($range ? 'daterange' : 'date'))->tip('年/月/日');
    }

    /**
     * 设置为区间选择
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:14:40
     * @param $range
     * @return Datetime
     */
    public function range($range = true)
    {
        //设置类型
        return $this->set('type', ($range ? 'datetimerange' : 'datetime'))->tip('年/月/日 时:分:秒');
    }

    /**
     * 设置是否隐藏秒
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:21:17
     * @param $hide
     * @return Datetime
     */
    public function hideSecond($hide = true)
    {
        //设置是否隐藏秒
        return $this->setExtra('hideSecond', $hide);
    }


}
