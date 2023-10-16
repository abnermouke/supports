<?php

namespace Abnermouke\Supports\Builders\Form\Items;

use Abnermouke\Supports\Library\HelperLibrary;

/**
 * 单图内容构建器
 */
class Image extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $label
     */
    public function __construct($field, $label)
    {
        //引入父级构造
        parent::__construct('image', $field, $label);
        //设置默认参数
        $this->dictionary()->sizeType()->sourceType()->extension()->crop(200, 200, 80, false)->setExtra('crop', false)->maxSize()->choose_text($label)->tip('点击图片上传按钮选择上传')->chooseParamters()->setExtra('maxCount', 1);
    }

    /**
     * 设置选择文案
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:33:50
     * @param $text
     * @return Image
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
     * @Time 2023-09-21 23:01:50
     * @param $dictionary
     * @return Image
     */
    public function dictionary($dictionary = 'uploader/builders/images') {
        //设置目录
        return $this->setExtra('dictionary', $dictionary);
    }

    /**
     * 设置可选文件类型
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:25:28
     * @param $original
     * @param $compressed
     * @return Image
     */
    public function sizeType($original = true, $compressed = true)
    {
        //整理可选类型
        $sizeType = [];
        //判断信息
        $original && $sizeType[] = 'original';
        $compressed && $sizeType[] = 'compressed';
        //设置可选文件类型
        return $this->setExtra('sizeType', $sizeType)->chooseParamters();
    }

    /**
     * 设置图片来源方式
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:27:00
     * @param $camera
     * @param $album
     * @return Image
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
     * @return Image
     */
    public function extension($extensions = [])
    {
        //设置图片扩展名
        return $this->setExtra('extension', $extensions)->chooseParamters()->mergeTips($extensions ? '允许的文件后缀：'.implode('、', $extensions) : '');
    }

    /**
     * 设置自动裁剪
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:29:37
     * @param $widh
     * @param $height
     * @return Image
     */
    public function crop($widh = 200, $height = 200, $tip = true)
    {
        //设置自动裁剪
        return $this->setExtra('crop', true)->setExtra('cropper', compact('widh', 'height'))->chooseParamters()->mergeTips($tip ? "建议尺寸：$widh x $height 及其等比例放大/缩小尺寸" : '');
    }

    /**
     * 设置最大文件大小
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:31:43
     * @param $size int 单位：KB
     * @return Image
     */
    public function maxSize($size = 0)
    {
        //设置最大文件大小
        return $this->setExtra('maxSize', $size)->mergeTips($size > 0 ? '允许的文件大小：'.HelperLibrary::friendlyFileSize($size * 1024) : '')->chooseParamters();
    }

    /**
     * 更新选择参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 23:02:15
     * @return Image
     */
    private function chooseParamters()
    {
        //整理基本参数
        $paramters = [
            'count' => 1,
            'sizeType' => data_get($this->builder, 'extras.sizeType', []),
            'extension' => data_get($this->builder, 'extras.extension', []),
            'sourceType' => data_get($this->builder, 'extras.sourceType', []),
            'crop' => data_get($this->builder, 'extras.crop', false) ? data_get($this->builder, 'extras.cropper', []) : []
        ];
        //获取素材列表参数
        $material_params = [
            'type' => 'image',
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
     * @Time 2023-09-22 17:37:23
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
