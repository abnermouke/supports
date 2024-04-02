<?php

namespace Abnermouke\Supports\Builders\Table;

use Abnermouke\Supports\Assists\Arr;
use Abnermouke\Supports\Builders\Route\Interfaces;
use Abnermouke\Supports\Builders\Route\Navigate;
use Abnermouke\Supports\Builders\Statistics\StatisticsBuilder;
use Abnermouke\Supports\Builders\Table\Filters\Datetime;
use Abnermouke\Supports\Builders\Table\Filters\Input;
use Abnermouke\Supports\Builders\Table\Filters\Location;
use Abnermouke\Supports\Builders\Table\Filters\Options;
use Abnermouke\Supports\Builders\Table\Filters\Range;
use Abnermouke\Supports\Builders\Table\Items\Cover;
use Abnermouke\Supports\Builders\Table\Items\Desc;
use Abnermouke\Supports\Builders\Table\Items\Header;
use Abnermouke\Supports\Builders\Table\Items\Infos;
use Abnermouke\Supports\Builders\Table\Items\Mark;
use Abnermouke\Supports\Builders\Table\Items\Schedules;
use Abnermouke\Supports\Builders\Table\Items\Tags;
use Abnermouke\Supports\Builders\Table\Items\Title;
use Abnermouke\Supports\Library\Cryptography\AesLibrary;

/**
 * 表格构建器
 */
class Builder
{

    //整理渲染数据
    protected $renders = [
        'query' => [],
        'sorts' => [],
        'filters' => [],
        'search' => [],
        'tools' => [],
        'items' => [],
        'actions' => [],
        'options' => [],
        'shortcuts' => [],
        'noticeBar' => [],
        'statistics' => [],
        'formData' => ['page' => 1, 'page_size' => 10, 'filters' => [], 'sorts' => []],
        'texts' => [],
        'extras' => [
            'themes' => [],
            'resets' => ['filters' => [], 'sorts' => []],
            'defaults' => ['page' => 1, 'page_size' => 10, 'filters' => [], 'sorts' => []],
            'query' => ['alias' => '', 'default' => []],
        ],
    ];

    /**
     * 构造函数
     */
    public function __construct()
    {
        //设置默认信息
        $this->set('extras', [])->setTexts()->setSearch()->defaultData()->setThemes()->defaultQueryAlias();
    }

    /**
     * 设置主题色
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 22:28:24
     * @param $primary
     * @param $default string 字体默认颜色
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
     * @Time 2023-10-23 00:08:56
     * @param $request
     * @return $this|m.\Abnermouke\Supports\Builders\Table\Builder.setThemes
     */
    public function setRequest($request)
    {
        //设置请求信息
        return $this->setThemes(data_get($request->all(), '__device__.themes.color', '#1966FF'), data_get($request->all(), '__device__.themes.mian', '#333333'));
    }

    /**
     * 设置默认文字提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:25:56
     * @param $tools
     * @param $filter
     * @param $filters
     * @param $loading
     * @param $finished
     * @param $empty
     * @param $filters_confirm
     * @param $filters_reset
     * @param $sorts_reset
     * @return $this
     */
    public function setTexts($tools = '常用工具', $filter = '筛选', $filters= '自定义筛选项', $loading = '正在加载列表...', $finished = '我也是有底线的', $empty = '暂无相关数据展示', $filters_confirm = '立即筛选', $filters_reset = '清空条件', $sorts_reset = '清空排序')
    {
        //设置文字提示
        return $this->set('texts', compact('tools', 'filter', 'filters', 'loading', 'finished','empty', 'filters_confirm', 'filters_reset', 'sorts_reset'));
    }

    /**
     * 设置表格内容信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:57:32
     * @param \Closure $callback
     * @return $this
     */
    public function setItems(\Closure $callback)
    {
        //获取筛选信息
        $this->set('items', tap(new Items(), $callback)->get());
        //循环信息
        foreach ($this->renders['items']['contents'] as $k => $item) {
            //判断信息
            if ($item instanceof Title || $item instanceof Desc || $item instanceof Schedules || $item instanceof Cover || $item instanceof Tags || $item instanceof Mark || $item instanceof Infos || $item instanceof Header) {
                //设置信息
                $this->renders['items']['contents'][$k] = $item->get();
            }
        }
        //返回当前实例
        return $this;
    }

    /**
     * 设置表格筛选信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:27:42
     * @param \Closure $callback
     * @return $this
     */
    public function setFilters(\Closure $callback)
    {
        //获取筛选信息
        $this->set('filters', tap(new Filters(), $callback)->get());
        //循环信息
        foreach ($this->renders['filters']['contents'] as $k => $filter) {
            //判断信息
            if ($filter instanceof Input || $filter instanceof Range || $filter instanceof Options || $filter instanceof Datetime || $filter instanceof Location) {
                //设置信息
                $this->renders['filters']['contents'][$k] = $filter->get();
            }
        }
        //返回当前实例
        return $this;
    }

    /**
     * 设置表格工具
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:20:04
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
     * 设置表格操作信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 00:59:14
     * @param \Closure $callback
     * @return $this
     */
    public function setActions(\Closure $callback)
    {
        //获取工具信息
        $this->set('actions', tap(new Actions(), $callback)->get());
        //循环信息
        foreach ($this->renders['actions']['contents'] as $k => $action) {
            //判断信息
            if ($action instanceof Navigate || $action instanceof Interfaces) {
                //设置信息
                $this->renders['actions']['contents'][$k] = $action->get();
            }
        }
        //返回当前实例
        return $this;
    }

    /**
     * 设置默认搜索信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 22:00:49
     * @param $placeholder
     * @param $field
     * @param $type
     * @return $this
     */
    public function setSearch($placeholder = '请输入关键词', $field = '__keyword__', $type = 'text')
    {
        //设置默认搜索信息
        return $this->set('search', compact('placeholder', 'field', 'type'));
    }

    /**
     * 设置排序信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:58:57
     * @param \Closure $callback
     * @return $this
     */
    public function setSorts(\Closure $callback)
    {
        //设置排序信息
        return $this->set('sorts', tap(new Sorts(), $callback)->get());
    }

    /**
     * 设置请求信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:55:10
     * @param \Closure $callback
     * @return $this
     */
    public function setQuery(\Closure $callback)
    {
        //设置请求信息
        return $this->set('query', tap(new Query(), $callback)->get());
    }

    /**
     * 设置表格快速操作信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 01:03:30
     * @param \Closure $callback
     * @return $this
     */
    public function setShortcuts(\Closure $callback)
    {
        //设置请求信息
        return $this->set('shortcuts', tap(new Shortcuts(), $callback)->get());
    }

    /**
     * 设置统计信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:41:55
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
     * 设置通知栏
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:39:56
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
     * 设置默认数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-19 01:09:28
     * @param $filetrs
     * @param $sorts
     * @param $page
     * @param $page_size
     * @return $this
     */
    public function defaultData($filetrs = [], $sorts = [], $page = 1, $page_size = 20)
    {
        //设置默认数据
        return $this->setExtra('defaults', compact('filetrs', 'sorts', 'page_size', 'page'));
    }

    /**
     * 设置默认请求标识
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-11-03 12:35:46
     * @param $alias
     * @return $this
     */
    public function defaultQueryAlias($alias = '')
    {
        //设置默认请求标识
        return $this->setExtra('query.alias', $alias);
    }

    /**
     * 配置表格渲染信息
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
        data_set($this->renders, $key, $value);
        //返回当前实例
        return $this;
    }

    /**
     * 设置表格额外渲染信息
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
        data_set($this->renders, 'extras.'.$key, $value);
        //返回当前实例
        return $this;
    }

    /**
     * 渲染前置
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:36:32
     * @return true
     */
    private function beforeRender()
    {
        //初始化参数
        foreach (Arr::except($this->renders, ['formData', 'extras', 'search', 'texts']) as $key => $value) {
            //判断信息
            if (!$value || !isset($value['enable'])) {
                //设置信息
                $this->renders[$key] = ['enable' => false, 'contents' => []];
            }
        }
        //判断是否没有排序
        if (!$this->renders['sorts']['enable']) {
            //设置默认排序
            $this->setSorts(function (Sorts $sorts) {
                $sorts->create('id', '综合');
                $sorts->create('created_at', '创建时间');
                $sorts->create('updated_at', '更新时间');
            });
        }
        //执行成功
        return true;
    }

    /**
     * 渲染数据整理
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:36:44
     * @return true
     */
    private function arrangeRender()
    {
        //初始化内容信息
        $items = [];
        //判断项目内容元素是否生效
        if ($this->renders['items']['enable']) {
            //循环项目内容
            foreach ($this->renders['items']['contents'] as $k => $item) {
                //根据表格内容类型处理
                switch ($item['type']) {
                    case 'infos':
                    case 'schedules':
                        //设置信息
                        $items[$item['type']][] = $item;
                        break;
                    default:
                        //设置信息
                        $items[$item['type']] = $item;
                        break;
                }
            }
            //循环信息
            foreach (['title', 'cover', 'desc', 'schedules', 'tags', 'infos', 'mark', 'header'] as $field) {
                //判断信息
                if (!data_get($items, $field, false)) {
                    //设置信息
                    $items[$field] = false;
                }
            }
        }
        //设置信息
        $this->renders['items'] = $items;
        //判断筛选条件是否生效
        if ($this->renders['filters']['enable']) {
            //设置默认重置信息
            $reset_filters = [$this->renders['search']['field'] => ''];
            //循环筛选条件
            foreach ($this->renders['filters']['contents'] as $k => $filter) {
                //根据类型处理
                switch ($filter['type']) {
                    case 'date':
                    case 'datetime':
                    case 'daterange':
                    case 'datetimerange':
                    case 'input':
                        //设置筛选内容
                        $this->renders['formData']['filters'][$filter['field']] = data_get($this->renders['extras'], ('defaults.filters.'.$filter['field']), '');
                        //设置默认重置筛选信息
                        $reset_filters[$filter['field']] = '';
                        break;
                    case 'options':
                        //设置筛选内容
                        $this->renders['formData']['filters'][$filter['field']] = data_get($this->renders['extras'], ('defaults.filters.'.$filter['field']), []);
                        //设置默认重置筛选信息
                        $reset_filters[$filter['field']] = [];
                        break;
                    case 'location':
                        //设置筛选内容
                        $this->renders['formData']['filters'][$filter['field']] = data_get($this->renders['extras'], ('defaults.filters.'.$filter['field']), [0, '未知']);
                        //设置默认重置筛选信息
                        $reset_filters[$filter['field']] = [0, '未知'];
                        break;
                    case 'range':
                        //设置筛选内容
                        $this->renders['formData']['filters'][$filter['field']] = data_get($this->renders['extras'], ('defaults.filters.'.$filter['field']), ['', '']);
                        //设置默认重置筛选信息
                        $reset_filters[$filter['field']] = ['', ''];
                        break;
                }
            }
            //设置默认筛选信息
            $this->setExtra('resets.filters', $reset_filters);
        }
        //设置筛选内容
        $this->renders['formData']['filters'][$this->renders['search']['field']] = data_get($this->renders['extras'], ('defaults.filters.'.$this->renders['search']['field']), '');
        //判断排序是否生效
        if ($this->renders['sorts']['enable']) {
            //设置默认重置信息
            $reset_sorts = [];
            //循环排序
            foreach ($this->renders['sorts']['contents'] as $k => $sort) {
                //设置默认排序
                $this->renders['formData']['sorts'][$sort['table_field']] = data_get($this->renders['extras'], ('defaults.sorts.'.$sort['table_field']), '');
                //设置排序信息
                $reset_sorts[$sort['table_field']] = '';
            }
            //设置默认排序信息
            $this->setExtra('resets.sorts', $reset_sorts);
        }
        //判断工具是否生效
        if ($this->renders['tools']['enable']) {
            //循环工具
            foreach ($this->renders['tools']['contents'] as $k => $tool) {
                //设置信息
                $this->renders['tools']['contents'][$k] = array_merge($tool, ['text' => $tool['name'], 'color' => $this->renders['extras']['themes'][$tool['theme']]]);
            }
        }
        //判断是否存在进度内容元素
        if ($this->renders['items']['schedules']) {
            //循环元素
            foreach ($this->renders['items']['schedules'] as $k => $schedule) {
                //设置元素颜色
                $this->renders['items']['schedules'][$k]['extras']['on']['color'] = $this->renders['extras']['themes']['success'];
                $this->renders['items']['schedules'][$k]['extras']['off']['color'] = $this->renders['extras']['themes']['danger'];
                $this->renders['items']['schedules'][$k]['extras']['verify']['color'] = $this->renders['extras']['themes']['info'];
                $this->renders['items']['schedules'][$k]['extras']['fail']['color'] = $this->renders['extras']['themes']['warning'];
                $this->renders['items']['schedules'][$k]['extras']['delete']['color'] = $this->renders['extras']['themes']['danger'];
            }
        }
        //判断是否存在请求信息
        if ($this->renders['query']['enable']) {
            //整理信息
            $default = $states = [];
            //循环元素
            foreach ($this->renders['query']['contents'] as $k => $query) {
                //判断当前是否为默认
                if ($query['default']) {
                    //设置为默认
                    $default = $query;
                } else {
                    //设置为更多
                    $states[] = $query;
                }
            }
            //判断是否有默认
            if (!$default) {
                //设置第一个
                $default = $states[0];
                unset($states[0]);
            }
            //设置信息
            $this->renders['query'] = array_merge($this->renders['query'], compact('default', 'states'));
            //整理全部query
            $queries = $this->renders['query']['contents'];
            //设置默认请求
            $this->setExtra('query.default', $queries[0]);
            //判断是否指定
            if ($this->renders['extras']['query']['alias']) {
                //设置信息
                $this->setExtra('query.default', data_get(array_column($queries, null, 'alias'), $this->renders['extras']['query']['alias'], $queries[0]));
            }
        }
        //设置默认页码等数据
        $this->renders['formData'] = array_merge($this->renders['formData'], Arr::only($this->renders['extras']['defaults'], ['page', 'page_size']));
        //整理操作项目
        $options = [];
        //判断是否存在操作
        if ($this->renders['actions']['enable']) {
            //初始化默认操作
            $actions = [];
            //循环操作
            foreach ($this->renders['actions']['contents'] as $k => $action) {
                //判断是否为主要操作
                if ($action['theme'] == \Abnermouke\Supports\Builders\Route\Builder::THEME_OF_PRIMARY || $action['conditions']) {
                    //设置默认操作
                    $actions[] = $action;
                } else {
                    //设置信息
                    $options[] = [
                        'text' => $action['name'],
                        'color' => $this->renders['extras']['themes'][$action['theme']],
                        'params' => $action
                    ];
                }
            }
            //设置信息
            $this->renders['actions'] = ['enable' => !empty($actions), 'contents' => $actions];
        }
        //设置信息
        $this->renders['options'] = ['enable' => !empty($options), 'contents' => $options];
        //执行成功
        return true;
    }

    /**
     * 渲染后置
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:36:39
     * @return true
     */
    private function afterRender()
    {
        //剔除非必要数据
        unset($this->renders['extras']['defaults']);
        //排序内容
        ksort($this->renders['formData']['sorts']);
        ksort($this->renders['extras']['resets']['sorts']);
        //排序内容
        ksort($this->renders['formData']['filters']);
        ksort($this->renders['extras']['resets']['filters']);
        //执行成功
        return true;
    }

    /**
     * 返回渲染数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 21:36:04
     * @return array|mixed
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
