<?php

namespace Abnermouke\Supports\Builders\Form;

use Abnermouke\Supports\Assists\Arr;
use Abnermouke\Supports\Builders\Form\Items\Album;
use Abnermouke\Supports\Builders\Form\Items\Attribute;
use Abnermouke\Supports\Builders\Form\Items\Datetime;
use Abnermouke\Supports\Builders\Form\Items\Editor;
use Abnermouke\Supports\Builders\Form\Items\File;
use Abnermouke\Supports\Builders\Form\Items\Group;
use Abnermouke\Supports\Builders\Form\Items\Image;
use Abnermouke\Supports\Builders\Form\Items\Input;
use Abnermouke\Supports\Builders\Form\Items\Option;
use Abnermouke\Supports\Builders\Form\Items\Parameter;
use Abnermouke\Supports\Builders\Form\Items\Select;
use Abnermouke\Supports\Builders\Form\Items\Tags;
use Abnermouke\Supports\Builders\Form\Items\Textarea;
use Abnermouke\Supports\Builders\Form\Items\Video;
use Abnermouke\Supports\Builders\Route\Interfaces;
use Abnermouke\Supports\Builders\Route\Navigate;
use Abnermouke\Supports\Builders\Statistics\StatisticsBuilder;
use Abnermouke\Supports\Library\HelperLibrary;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

/**
 * 表单构建器
 */
class Builder
{


    //整理渲染数据
    protected $renders = [
        'tools' => [],
        'items' => [],
        'noticeBar' => [],
        'statistics' => [],
        'chunks' => [],
        'formData' => [],
        'handlers' => [],
        'texts' => [],
        'extras' => [
            'jsons' => [],
            'chooseImageSheets' => [],
            'themes' => [],
            'defaults' => [],
        ],
    ];

    /**
     * 构造函数
     */
    public function __construct()
    {
        //设置默认信息
        $this->set('extras', [])->defaultData()->setThemes()->setHandlers('', '')->setTexts()->setMaterialDrawer()->setDragSortDrawer();
    }

    /**
     * 设置文字提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 23:48:50
     * @param $choose_local
     * @param $choose_materials
     * @return $this
     */
    public function setTexts($choose_local = '本地上传', $choose_materials = '在线素材上传', $quick_title = '快捷导航', $tools = '操作工具')
    {
        //设置文字提示
        return $this->set('texts', compact('choose_local', 'choose_materials', 'quick_title', 'tools'));
    }

    /**
     * 设置素材弹窗相关信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-22 01:43:08
     * @param $title
     * @param $desc
     * @param $types
     * @return $this
     */
    public function setMaterialDrawer($types = ['image' => '图像类', 'video' => '视频类', 'text' => '文本类', 'audio' => '音频类', 'application' => '应用类', 'unkonwn' => '未知类'], $desc = '', $title = '在线素材', $placeholder = '请输入素材文件名等关键词', $all = '全部', $search = '立即查询', $empty = '暂无相关素材', $loading = '正在加载...', $finished = '我也是有底线的', $loadmore = '点击加载更多素材', $cancel = '放弃选择', $confirm = '确认选择')
    {
        //整理sheets
        $sheets = [];
        //循环类型
        foreach ($types as $type => $text) {
            //设置信息
            $sheets[] = ['text' => $text, 'type' => $type, 'color' => '#333333'];
        }
        //设置素材弹窗相关信息
        return $this->setExtra('materialDrawer', compact('sheets', 'title', 'desc', 'types', 'placeholder', 'all', 'search', 'empty', 'loading', 'finished', 'loadmore', 'cancel', 'confirm'));
    }

    /**
     * 设置文件拖拽弹窗相关信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-26 12:01:43
     * @param $desc
     * @param $title
     * @return $this|m.\Abnermouke\Supports\Builders\Form\Builder.setExtra
     */
    public function setDragSortDrawer($desc = '点击文件后方图标可进行上下调节排序，同时可选择删除文件', $title = '文件排序', $confirm = '确认修改', $trigger = '排序/删除')
    {
        //设置文件拖拽弹窗相关信息
        return $this->setExtra('dragSortDrawer', compact('desc', 'title', 'confirm', 'trigger'));
    }

    /**
     * 设置处理接口链接
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 22:19:24
     * @param $uploader
     * @param $materials
     * @return $this
     */
    public function setHandlers($uploader, $materials)
    {
        //设置处理器
        return $this->set('handlers', compact('uploader', 'materials'));
    }

    /**
     * 设置主题色
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 09:53:11
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
     * @Time 2023-10-23 01:16:40
     * @param $request
     * @return $this|m.\Abnermouke\Supports\Builders\Form\Builder.setThemes
     */
    public function setRequest($request)
    {
        //设置请求信息
        return $this->setThemes(data_get($request->all(), '__device__.themes.color', '#1966FF'), data_get($request->all(), '__device__.themes.mian', '#333333'));
    }

    /**
     * 设置表单内容信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:12:34
     * @param \Closure $callback
     * @return $this
     */
    public function setItems(\Closure $callback)
    {
        //获取筛选信息
        $this->set('items', tap(new Items(), $callback)->get());
        //初始化信息
        $items = [];
        //循环信息
        foreach ($this->renders['items']['contents'] as $k => $item) {
            //判断信息
            if ($item instanceof Album || $item instanceof Attribute || $item instanceof Datetime || $item instanceof File || $item instanceof Image || $item instanceof Input || $item instanceof Option || $item instanceof Parameter || $item instanceof Select || $item instanceof Tags || $item instanceof Textarea || $item instanceof Video || $item instanceof Group || $item instanceof Editor) {
                //获取数据
                $item = $item->get();
            }
            //设置信息
            $items[$item['field']] = $item;
        }
        //设置信息
        $this->renders['items'] = $items;
        //返回当前实例
        return $this;
    }

    /**
     * 设置表单按钮工具
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:19:21
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
     * 设置表单分组信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 12:38:34
     * @param \Closure $callback
     * @return $this
     */
    public function setChunks(\Closure $callback)
    {
        //获取分组信息
        return $this->set('chunks', tap(new Chunks(), $callback)->get());
    }

    /**
     * 设置统计信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 09:52:55
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
     * @Time 2023-09-21 09:52:35
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
     * @Time 2023-09-21 09:52:21
     * @param $data
     * @return $this
     */
    public function defaultData($data = [])
    {
        //设置默认数据
        return $this->setExtra('defaults', $data);
    }

    /**
     * 配置表单渲染信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 09:52:12
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
     * 设置表单额外渲染信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 09:52:02
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
     * @Time 2023-09-21 09:51:55
     * @return true
     */
    private function beforeRender()
    {
        //初始化参数
        foreach (Arr::except($this->renders, ['formData', 'extras', 'items', 'handlers', 'texts']) as $key => $value) {
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
     * 渲染数据整理
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 09:51:49
     * @return true
     */
    private function arrangeRender()
    {
        //判断项目内容
        if ($this->renders['items']) {
            //循环项目内容
            foreach ($this->renders['items'] as $k => $item) {
                //根据类型处理
                switch ($item['type']) {
                    case 'album':
                    case 'attribute':
                    case 'files':
                    case 'parameter':
                    case 'tags':
                    case 'group':
                        //设置默认值
                        $this->renders['formData'][$item['field']] = HelperLibrary::objectToArray(data_get($this->renders['extras'], ('defaults.'.$item['field']), []));
                        break;
                    case 'option':
                        //设置默认值
                        $this->renders['formData'][$item['field']] = data_get($this->renders['extras'], ('defaults.'.$item['field']), []);
                        //判断是否为数组
                        $this->renders['formData'][$item['field']] = is_array($this->renders['formData'][$item['field']]) ?: [is_numeric($this->renders['formData'][$item['field']]) ? (int)$this->renders['formData'][$item['field']] : $this->renders['formData'][$item['field']]];
                        break;
                    case 'datetime':
                        //判断是否为区间选择
                        if ($item['extras']['range']) {
                            //设置默认值
                            if ($this->renders['formData'][$item['field']] = data_get($this->renders['extras'], ('defaults.'.$item['field']), [])) {
                                //设置显示值
                                $item['extras']['pickerValue'] = implode($item['extras']['separator'], $this->renders['formData'][$item['field']]);
                            }
                        } else {
                            //设置默认值
                            $this->renders['formData'][$item['field']] = $item['extras']['pickerValue'] = data_get($this->renders['extras'], ('defaults.'.$item['field']), '');
                        }
                        //设置信息
                        $this->renders['items'][$k] = $item;
                        break;
                    case 'select':
                        //设置默认值
                        if ($this->renders['formData'][$item['field']] = data_get($this->renders['extras'], ('defaults.'.$item['field']), '')) {
                            //初始化信息
                            $values = array_column($item['extras']['values'], null, 'value');
                            //设置选中值
                            $item['extras']['selectedValue'] = data_get($values, $this->renders['formData'][$item['field']].'.index', 0);
                            $item['extras']['selectedName'] = data_get($values, $this->renders['formData'][$item['field']].'.name', '');
                            //设置信息
                            $this->renders['items'][$k] = $item;
                        }
                        break;
                    case 'multi_select':
                        //设置默认值
                        $this->renders['extras']['jsons'][$item['field']] = [];
                        //获取json信息
                        if ($json = file_get_contents($item['extras']['columnJsonUrl'])) {
                            //初始化信息
                            $json_data = json_decode($json, true);
                            //初始化选型信息
                            $values = [];
                            $selectedValues = $selectedNames = [];
                            $searchKeys = [];
                            //循环栏数
                            for ($i = 0; $i < $item['extras']['column']; $i++) {
                                $values[$i] = [0 => ['value' => 0, 'name' => '请选择', 'iindex' => 0]];
                                $selectedValues[$i] = 0;
                            }
                            //循环文件信息
                            foreach ($json_data as $index => $datum) {
                                //设置信息
                                $values[0][$index] = Arr::only($datum, ['value', 'name', 'index']);
                            }
                            //设置默认值
                            if ($this->renders['formData'][$item['field']] = $defaukt_values = data_get($this->renders['extras'], ('defaults.'.$item['field']), [])) {
                                //初始化信息
                                $selectedValues[0] = array_column($json_data, 'index', 'value')[$defaukt_values[0]];
                                $selectedNames[0] = array_column($json_data, 'name', 'value')[$defaukt_values[0]];
                                //循环栏数
                                for ($i = 1; $i < $item['extras']['column']; $i++) {
                                    //获取当前值
                                    $current_value = $defaukt_values[$i];
                                    //查询选项
                                    foreach (($json_data = data_get($json_data, ($selectedValues[$i - 1]).'.subs', [])) as $index => $datum) {
                                        //设置信息
                                        $values[$i][$index] = Arr::only($datum, ['value', 'name', 'index']);
                                        //初始化信息
                                        $selectedValues[$i] = array_column($json_data, 'index', 'value')[$defaukt_values[$i]];
                                        $selectedNames[$i] = array_column($json_data, 'name', 'value')[$defaukt_values[$i]];
                                    }
                                }
                            }
                            //设置信息
                            $item['extras']['values'] = $values;
                            $item['extras']['selectedValues'] = $selectedValues;
                            $item['extras']['selectedNames'] = $selectedNames;
                            //设置信息
                            $this->renders['items'][$k] = $item;
                        }
                        break;
                    default:
                        //设置默认值
                        $this->renders['formData'][$item['field']] = data_get($this->renders['extras'], ('defaults.'.$item['field']), '');
                        break;
                }
            }
        }
        //判断是否有分组
        if (!$this->renders['chunks']['enable']) {
            //生成默认分组
            $this->setChunks(function (Chunks $chunks) {
                //创建默认模块
                $chunks->create(array_keys($this->renders['items']));
            });
        }
        //循环所有模块
        foreach ($this->renders['chunks']['contents'] as $k => $chunk) {
            //设置信息
            $this->renders['chunks']['contents'][$k]['items'] = Arr::only($this->renders['items'], $chunk['fields'], []);
        }
        //判断是否设置对应处理对象
        if ($this->renders['handlers']['materials']) {
            //设置选择选择对象
            $this->renders['extras']['chooseSheets'][] = ['text' => $this->renders['texts']['choose_materials'], 'color' => $this->renders['extras']['themes']['primary'], 'local' => false];
        }
        //判断是否设置对应处理对象
        if ($this->renders['handlers']['uploader']) {
            //设置选择选择对象
            $this->renders['extras']['chooseSheets'][] = ['text' => $this->renders['texts']['choose_local'], 'color' => '#333333', 'local' => true];
        }
        //执行成功
        return true;
    }

    /**
     * 渲染后置
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 09:51:36
     * @return true
     */
    private function afterRender()
    {
        //剔除非必要数据
        $this->renders['extras']['defaults'] = $this->renders['formData'];
        //执行成功
        return true;
    }

    /**
     * 返回渲染数据
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 09:51:27
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
