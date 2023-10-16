<?php

namespace Abnermouke\Supports\Builders\Route;

/**
 * 路由构建器
 */
class Builder
{

    //主题标识
    public const THEME_OF_DEFAULT = 'default';
    public const THEME_OF_PRIMARY = 'primary';
    public const THEME_OF_DANGER = 'danger';
    public const THEME_OF_WARNING = 'warning';
    public const THEME_OF_SUCCESS = 'success';
    public const THEME_OF_INFO = 'info';

    //图标标识
    public const ICON_OF_EDIT = 'edit';
    public const ICON_OF_CREATE = 'create';
    public const ICON_OF_DELETE = 'delete';
    public const ICON_OF_EXPORT = 'export';

    //请求/跳转包含数据标识
    public const INCLUDE_OF_TABLE_ROW = '__table_row__';
    public const INCLUDE_OF_FROM_DATA = '__form_data__';

    //构建器默认数据
    protected $builder = [];

    /**
     * 构造函数
     * @param $name
     * @param $type
     */
    public function __construct($name = '', $type = 'navigate')
    {
        //设置默认构建器内容
        $this->set('extras', [])->set('name', $name)->set('type', $type)->theme()->includes();
    }

    /**
     * 设置点击后确认提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 23:02:46
     * @param $text
     * @return $this
     */
    public function confirm($text = '')
    {
        //设置点击后确认提示
        return $this->set('confirm', $text);
    }

    /**
     * 设置是否图标显示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 22:15:38
     * @param $show
     * @param $alias
     * @return $this
     */
    public function icon($show = true, $alias = self::ICON_OF_EDIT)
    {
        //设置是否图标显示
        return $this->set('icon', $show)->setExtra('icon', $alias);
    }

    /**
     * 设置请求参数包含标识
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 22:20:14
     * @param $aliases
     * @return $this
     */
    public function includes($aliases = [])
    {
        //设置请求参数包含标识
        return $this->setExtra('includes', $aliases);
    }

    /**
     * 设置默认主题
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 22:10:38
     * @param $theme string default|primary|danger|warning|success|info
     * @return $this
     */
    public function theme($theme = Builder::THEME_OF_DEFAULT)
    {
        //设置默认主题
        return $this->set('theme', $theme);
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
