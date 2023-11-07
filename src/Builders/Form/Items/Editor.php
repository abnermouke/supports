<?php

namespace Abnermouke\Supports\Builders\Form\Items;

/**
 * 编辑器内容元素构建器
 */
class Editor extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $label
     */
    public function __construct($field, $label)
    {
        //引入父级构造
        parent::__construct('editor', $field, $label);
        //设置默认参数
        $this->texts(config('project.domains.console'))->tip('扫码控制台「EDITOR 编辑器」二维码进行操作')->handler('');
    }

    /**
     * 设置处理接口链接
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-07 14:15:58
     * @param $handler
     * @return Editor
     */
    public function handler($handler)
    {
        //设置处理接口链接
        return $this->setExtra('handler', $handler);
    }

    /**
     * 设置文本提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-07 09:27:41
     * @param $cons_domain
     * @param $tip
     * @param $scan
     * @param $preview
     * @param $clear
     * @return Editor
     */
    public function texts($cons_domain, $tip = '电脑端访问链接：', $scan = '扫码', $preview = '预览', $clear = '清空')
    {
        //设置文本提示
        return $this->setExtra('texts', compact('cons_domain', 'tip', 'scan', 'preview', 'clear'));
    }

}
