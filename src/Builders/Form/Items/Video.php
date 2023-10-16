<?php

namespace Abnermouke\Supports\Builders\Form\Items;

use Abnermouke\Supports\Library\HelperLibrary;

/**
 * 视频内容构建器
 */
class Video extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $label
     */
    public function __construct($field, $label)
    {
        //引入父级构造
        parent::__construct('video', $field, $label);
        //设置默认参数
        $this->dictionary()->sourceType()->extension()->maxSize()->choose_text($label)->compressed()->tip('点击视频上传按钮选择上传');
    }

    /**
     * 设置选择文案
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:33:50
     * @param $text
     * @return Video
     */
    public function choose_text($text)
    {
        //设置选择文案
        return $this->setExtra('chooseText', $text);
    }

    /**
     * 设置目录
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-23 12:11:17
     * @param $dictionary
     * @return Video
     */
     public function dictionary($dictionary = 'uploader/builders/videos') {
        //设置目录
        return $this->setExtra('dictionary', $dictionary)->chooseParamters();
    }

    /**
     * 设置可选文件类型
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:25:28
     * @param $compressed
     * @return Video
     */
    public function compressed($compressed = true)
    {
        //设置是否压缩视频源文件
        return $this->setExtra('compressed', $compressed)->chooseParamters();
    }

    /**
     * 设置图片来源方式
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:27:00
     * @param $camera
     * @param $album
     * @return Video
     */
    public function sourceType($camera = true, $album = true)
    {
        //整理图片来源方式
        $sourceType = [];
        //判断信息
        $album && $sourceType[] = 'album';
        $camera && $sourceType[] = 'camera';
        //设置图片来源方式
        return $this->setExtra('sourceType', $sourceType)->chooseParamters();
    }

    /**
     * 设置图片扩展名
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:27:54
     * @param $extensions
     * @return Video
     */
    public function extension($extensions = [])
    {
        //设置图片扩展名
        return $this->setExtra('extension', $extensions)->chooseParamters()->mergeTips($extensions ? '允许的文件后缀：'.implode('、', $extensions) : '');;
    }

    /**
     * 设置最大文件大小
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:31:43
     * @param $size int 单位：KB
     * @return Video
     */
    public function maxSize($size = 0)
    {
        //设置最大文件大小
        return $this->setExtra('maxSize', $size)->mergeTips($size > 0 ? '允许的文件大小：'.HelperLibrary::friendlyFileSize($size * 1024) : '');
    }

    /**
     * 更新选择参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-23 12:14:54
     * @return Video
     */
    private function chooseParamters()
    {
        //整理基本参数
        $paramters = [
            'count' => 1,
            'compressed' => data_get($this->builder, 'extras.compressed', false),
            'extension' => data_get($this->builder, 'extras.extension', []),
            'sourceType' => data_get($this->builder, 'extras.sourceType', []),
        ];
        //获取素材列表参数
        $material_params = [
            'type' => 'video',
        ];
        //判断是否限制大小
        if ((int)data_get($this->builder, 'extras.maxSize', 0) > 0) {
            //设置参数
            $material_params['size'] = (int)$this->builder['extras']['maxSize'] * 1024;
        }
        //判断是否限制文件后缀
        if ($extensions = data_get($this->builder, 'extras.extension', [])) {
            //设置参数
            $material_params['extension'] = ['in', $extensions];
        }
        //移除空白数据
        return $this->setExtra('chooseParamters', HelperLibrary::removeInvaildArray($paramters))->materialParams($material_params);
    }

    /**
     * 设置获取素材列表参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-23 12:14:58
     * @param $params
     * @return $this
     */
    public function materialParams($params = [])
    {
        //判断参数
        if ($params) {
            //获取当前配置
            $defaults = data_get($this->builder, 'extras.materialParams', []);
            //判断信息
            if ($defaults) {
                //设置参数
                $params = array_merge($defaults, $params);
            }
            //设置参数
            $this->setExtra('materialParams', $params);
        }
        //返回当前实例
        return $this;
    }

}
