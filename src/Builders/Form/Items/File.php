<?php

namespace Abnermouke\Supports\Builders\Form\Items;

use Abnermouke\Supports\Library\HelperLibrary;

/**
 * 文件内容构建器
 */
class File extends Builder
{

    /**
     * 构造函数
     * @param $field
     * @param $label
     */
    public function __construct($field, $label)
    {
        //引入父级构造
        parent::__construct('files', $field, $label);
        //设置默认参数
        $this->dictionary()->extension()->maxSize()->choose_text($label)->maxCount()->tip('点击文件上传按钮上传文件');
    }

    /**
     * 设置选择文案
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:33:50
     * @param $text
     * @return File
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
     * @Time 2023-09-25 23:17:06
     * @param $dictionary
     * @return File
     */
    public function dictionary($dictionary = 'uploader/builders/videos') {
        //设置目录
        return $this->setExtra('dictionary', $dictionary)->chooseParamters();
    }

    /**
     * 设置图片扩展名
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:27:54
     * @param $extensions
     * @return File
     */
    public function extension($extensions = [])
    {
        //设置图片扩展名
        return $this->setExtra('extension', $extensions)->chooseParamters()->mergeTips($extensions ? '允许的文件后缀：'.implode('、', $extensions) : '');
    }

    /**
     * 设置最大文件大小
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:31:43
     * @param $size int 单位：KB
     * @return File
     */
    public function maxSize($size = -1)
    {
        //设置最大文件大小
        return $this->setExtra('maxSize', $size)->mergeTips($size > 0 ? '允许的文件大小：'.HelperLibrary::friendlyFileSize($size * 1024) : '')->chooseParamters();
    }

    /**
     * 设置最多上传文件个数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-21 11:37:25
     * @param $count
     * @return File
     */
    public function maxCount($count = 0)
    {
        //设置最多上传图片个数
        return $this->setExtra('maxCount', $count)->setExtra('chooseCount', ($count > 0 ? min($count, 9) : 9))->chooseParamters()->mergeTips($count > 0 ? "允许的文件个数： $count 个" : '');
    }

    /**
     * 更新选择参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-25 23:18:36
     * @return File
     */
    private function chooseParamters()
    {
        //整理基本参数
        $paramters = [
            'count' => data_get($this->builder, 'extras.chooseCount', 10),
            'extension' => data_get($this->builder, 'extras.extension', [])
        ];
        //获取素材列表参数
        $material_params = [
            'type' => '',
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
     * @Time 2023-09-25 23:18:28
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
