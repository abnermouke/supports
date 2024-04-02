<?php

namespace Abnermouke\Supports\Builders\Infos;

use Abnermouke\Supports\Assists\Arr;
use Abnermouke\Supports\Builders\Infos\Items\Images;
use Abnermouke\Supports\Builders\Infos\Items\Options;
use Abnermouke\Supports\Builders\Infos\Items\Text;
use Abnermouke\Supports\Builders\Route\Interfaces;
use Abnermouke\Supports\Builders\Route\Navigate;
use Abnermouke\Supports\Builders\Statistics\StatisticsBuilder;
use Abnermouke\Supports\Builders\Infos\Tools;

/**
 * 信息展示构建器
 */
class Builder
{

    //整理渲染数据
    protected $renders = [
        'noticeBar' => [],
        'items' => [],
        'tools' => [],
        'statistics' => [],
        'data' => [],
        'extras' => [],
    ];

    public function __construct()
    {
        //设置默认信息
        $this->set('extras', [])->setThemes();
    }

    /**
     * 设置通知栏
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-03 14:18:51
     * @param $noticeBar
     * @return $this
     */
    public function setNoticeBar($noticeBar)
    {
        //判断是否为实例对象
        if ($noticeBar instanceof \Abnermouke\Supports\Builders\NoticeBar\Builder) {
            //获取内容
            $noticeBar = $noticeBar->get();
        }
        //设置信息
        return $this->set('noticeBar', $noticeBar);
    }

    /**
     * 设置统计信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-03 14:18:34
     * @param \Closure $callback
     * @return $this
     */
    public function setStatistics(\Closure $callback)
    {
        //设置统计基本信息
        $this->set('statistics', tap(new \Abnermouke\Supports\Builders\Statistics\Builder(), $callback)->get());
        //循环统计信息
        foreach ($this->renders['statistics']['contents'] as $k => $statistic) {
            //判断统计是否为实例
            if ($statistic instanceof StatisticsBuilder) {
                //设置信息
                $this->renders['statistics']['contents'][$k] = $statistic->get();
            }
        }
        //返回当前实例
        return $this;
    }

    /**
     * 设置信息展示操作工具
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-03 14:20:37
     * @param \Closure $callback
     * @return $this
     */
    public function setTools(\Closure $callback)
    {
        //获取工具信息
        $this->set('tools', tap(new Tools(), $callback)->get());
        //循环信息
        foreach ($this->renders['tools']['contents'] as $k => $tool) {
            //判断信息
            if ($tool instanceof Navigate || $tool instanceof Interfaces) {
                //设置信息
                $this->renders['tools']['contents'][$k] = $tool->get();
            }
        }
        //返回当前实例
        return $this;
    }

    /**
     * 设置信息展示项
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-03 14:35:47
     * @param \Closure $callback
     * @param $title
     * @param $alert_content
     * @param $alert_theme
     * @return $this
     */
    public function addItem(\Closure $callback, $title = '', $alert_content = '', $alert_theme = 'primary') {
        //获取内容项信息
        $contents = tap(new Items(), $callback)->get();
        //循环信息
        foreach ($contents as $k => $content) {
            //判断信息
            if ($content instanceof Text || $content instanceof Options || $content instanceof  Images) {
                //设置信息
                $contents[$k] = $content->get();
            }
        }
        //设置信息
        $this->renders['items'][] = compact('title', 'contents', 'alert_content', 'alert_theme');
        //返回当前实例
        return $this;
    }

    /**
     * 设置主题色
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-03 14:12:49
     * @param $primary
     * @param $default
     * @param $danger
     * @param $warning
     * @param $success
     * @param $info
     * @return $this
     */
    public function setThemes($primary = '#1966FF', $default = '#333333', $danger = '#FA5151', $warning = '#FFC300', $success = '#07C160', $info = '#10AEFF')
    {
        //设置主题色
        return $this->setExtra('themes', compact('primary', 'danger', 'warning', 'success', 'info', 'default'));
    }

    /**
     * 设置请求信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-03 14:12:59
     * @param $request
     * @return $this
     */
    public function setRequest($request)
    {
        //设置请求信息
        return $this->setThemes(data_get($request->all(), '__device__.themes.color', '#1966FF'), data_get($request->all(), '__device__.themes.mian', '#333333'));
    }

    /**
     * 设置信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-05 22:27:39
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        //设置信息内容
        return $this->set('data', $data);
    }

    /**
     * 配置信息展示渲染信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-03 14:11:18
     * @param $key
     * @param $value
     * @return $this
     */
    private function set($key, $value)
    {
        //设置信息
        data_set($this->renders, $key, $value);
        //返回当前实例
        return $this;
    }

    /**
     * 设置信息展示额外渲染信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-03 14:11:04
     * @param $key
     * @param $value
     * @return $this
     */
    private function setExtra($key, $value)
    {
        //设置信息
        data_set($this->renders, 'extras.'.$key, $value);
        //返回当前实例
        return $this;
    }

    /**
     * 执行渲染前置
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-03 14:11:58
     * @return true
     */
    private function beforeRender()
    {
        //初始化参数
        foreach (Arr::except($this->renders, ['extras', 'items', 'data']) as $key => $value) {
            //判断信息
            if (!$value || !isset($value['enable'])) {
                //设置信息
                $this->renders[$key] = ['enable' => false, 'contents' => []];
            }
        }
        //执行成功
        return true;
    }

    /**
     * 整理渲染数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-03 14:12:03
     * @return true
     */
    private function arrangeRender()
    {
        //循环字段信息
        foreach ($this->renders['items'] as $k => $item) {
            //循环内容
            foreach ($item['contents'] as $ck => $content) {
                //判断信息是否存在
                if (!data_get($this->renders['data'], $content['field'], false)) {
                    //设置信息
                    $this->renders['data'][$content['field']] = '';
                }
                //根据类型处理
                switch ($content['type']) {
                    case 'images':
                        //判断信息
                        if (is_string($this->renders['data'][$content['field']])) {
                            //设置信息
                            $this->renders['data'][$content['field']] = explode(',', $this->renders['data'][$content['field']]);
                        }
                        break;
                }
            }
        }
        //执行成功
        return true;
    }

    /**
     * 执行渲染后置
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-03 14:12:08
     * @return true
     */
    private function afterRender()
    {
        //执行成功
        return true;
    }

    /**
     * 返回渲染数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-03 14:12:12
     * @return array[]|mixed
     */
    public function render()
    {
        //执行渲染前置
        $this->beforeRender();
        //整理渲染数据
        $this->arrangeRender();
        //执行渲染后置
        $this->afterRender();
        //返回信息
        return $this->renders;
    }



}
