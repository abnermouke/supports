<?php

namespace Abnermouke\Supports\Builders\NoticeBar;

/**
 * 通告栏构建器
 * 配置参数参考UNIAPP组件：https://uniapp.dcloud.net.cn/component/uniui/uni-notice-bar.html
 */
class Builder
{

    //整理默认构建数据
    private $contents = [];

    /**
     * 构造函数
     */
    public function __construct()
    {
        //设置默认构建参数
        $this->set('extras', [])->speed()->text()->color()->bgcolor()->scrollable()->icon()->close(false)->more(false)->target();
    }

    /**
     * 设置文字滚动速度(px/s)
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:38:57
     * @param $speed
     * @return $this
     */
    public function speed($speed = 70)
    {
        //设置文字滚动速度
        return $this->set('speed', $speed);
    }

    /**
     * 设置通告栏文字颜色
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:50:04
     * @param $color
     * @return $this
     */
    public function color($color = '#FF9F18')
    {
        //设置通告栏文字颜色
        return $this->set('color', $color);
    }

    /**
     * 设置通告栏背景颜色
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:50:09
     * @param $color
     * @return $this
     */
    public function bgcolor($color = 'rgba(255,159,24,0.2)')
    {
        //设置通告栏背景颜色
        return $this->set('bgcolor', $color);
    }

    /**
     * 设置显示文字
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:50:14
     * @param $text
     * @return $this
     */
    public function text($text = '')
    {
        //设置显示文字
        return $this->set('text', $text);
    }

    /**
     * 设置是否滚动
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:50:19
     * @param $scrollable
     * @param $single
     * @return Builder
     */
    public function scrollable($scrollable = true, $single = true)
    {
        //设置是否滚动
        return $this->set('scrollable', $scrollable)->single($single);
    }

    /**
     * 设置是否单行显示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:50:26
     * @param $single
     * @return $this
     */
    public function single($single = true)
    {
        //设置是否单行显示
        return $this->set('single', $single);
    }

    /**
     * 设置是否限制左侧喇叭图标
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:50:30
     * @param $show
     * @return $this
     */
    public function icon($show = true)
    {
        //设置是否限制左侧喇叭图标
        return $this->set('showIcon', $show);
    }

    /**
     * 设置是否显示关闭图标
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:50:35
     * @param $show
     * @param $target_alias
     * @param $target_params
     * @return Builder
     */
    public function close($show = true, $target_alias = 'none', $target_params = [])
    {
        //设置是否显示关闭图标
        return $this->set('showClose', $show)->setExtra('close', ['alias' => $target_alias, 'params' => $target_params]);
    }

    /**
     * 设置是否显示关闭图标
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:50:39
     * @param $show
     * @param $target_alias
     * @param $target_params
     * @return Builder
     */
    public function more($show = true, $target_alias = 'none', $target_params = [])
    {
        //设置是否显示查看更多图标
        return $this->set('showGetMore', $show)->setExtra('more',['alias' => $target_alias, 'params' => $target_params]);
    }

    /**
     * 设置跳转链接
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:50:48
     * @param $alias
     * @param $params
     * @return $this
     */
    public function target($alias = 'none', $params = [])
    {
        //设置跳转链接
        return $this->setExtra('click', compact('alias', 'params'));
    }

    /**
     * 配置通告栏构建信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:37:31
     * @param $key
     * @param $value
     * @return $this
     */
    private function set($key, $value)
    {
        //设置信息
        $this->contents[$key] = $value;
        //返回当前实例
        return $this;
    }

    /**
     * 设置通告栏额外构建信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:37:06
     * @param $key
     * @param $value
     * @return $this
     */
    private function setExtra($key, $value)
    {
        //设置信息
        $this->contents['extras'][$key] = $value;
        //返回当前实例
        return $this;
    }

    /**
     * 获取通告栏信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 20:36:51
     * @return array
     */
    public function get()
    {
        //返回信息
        return ['enable' => !empty($this->contents['text']), 'contents' => $this->contents];
    }
}
