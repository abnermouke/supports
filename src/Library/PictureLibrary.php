<?php

namespace Abnermouke\Supports\Library;

use Abnermouke\Supports\Assists\File;
use Abnermouke\Supports\Assists\Path;
use Intervention\Image\ImageManager;

/**
 * 图片处理藏库
 */
class PictureLibrary
{

    //图片实例
    private $image;

    //源图片路径
    private $source_path;

    /**
     * 创建图片处理类实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 18:04:07
     * @param $source_path string 源图片绝对路径
     * @return PictureLibrary
     */
    public static function make($source_path)
    {
        return new PictureLibrary($source_path);
    }

    /**
     * 构造函数
     * @param $source_path string 源图片绝对路径
     */
    public function __construct($source_path)
    {
        //生成图片实例
        $this->image = (new ImageManager())->make(($this->source_path = $source_path));
    }

    /**
     * 写入水印图片
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 18:10:15
     * @param string $picture 水印图片绝对地址
     * @param int $width 宽度
     * @param int $height 高度
     * @param int $x x坐标
     * @param int $y y坐标
     * @param string $position 写入位置
     * @return $this
     */
    public function drawl($picture, $width = 100, $height = 100, $x = 0, $y = 0, $position = 'top-left')
    {
        //整理水印图片
        $watermark = (new ImageManager())->make($picture)->resize($width, $height);
        //设置图片
        $this->image->insert($watermark, $position, $x, $y);
        //释放内存
        unset($watermark);
        //返回当前实例
        return $this;
    }

    /**
     * 写入文字水印
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 18:10:45
     * @param string $string 文字内容
     * @param string|bool $ttf 字体文件绝对路径
     * @param int $x x轴坐标
     * @param int $y y轴坐标
     * @param int $font_size 文字大小
     * @param string $color 颜色
     * @param string $align_position 水平位置
     * @param string $valigin_position 垂直位置
     * @return $this
     */
    public function text($string, $ttf, $x = 0, $y = 0, $font_size = 20, $color = '#000000', $align_position = 'left', $valigin_position = 'top')
    {
        //设置文字水印
        $this->image->text($string, $x, $y, function ($font) use ($font_size, $color, $ttf, $align_position, $valigin_position) {
            //设置文字属性
            $font->file($ttf);
            $font->size($font_size);
            $font->color($color);
            $font->align($align_position);
            $font->valign($valigin_position);
        });
        //返回当前实例
        return $this;
    }

    /**
     * 裁剪为正方形（常用于自动拆剪商品详情图）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 18:27:37
     * @param $prefix
     * @param $quality
     * @param $format
     * @return array
     */
    public function squares($prefix = 'square-', $quality = 100, $format = null)
    {
        //整理文件集合
        $file_paths = [];
        //获取图片实例
        $img = $this->image;
        //获取源文件地址
        $source_path = $this->source_path;
        //根据宽高获取指定截取张数
        $numbers = (int)ceil($img->height()/$img->width());
        //获取文件信息
        $path_info = pathinfo($source_path);
        //循环处理图片信息
        for ($i = 0; $i < $numbers; $i++) {
            //整理新文件地址
            $new_path = $path_info['dirname'].DIRECTORY_SEPARATOR.$prefix.$i.'_'.$path_info['basename'];
            //复制文件
            File::copy($source_path, $new_path);
            //实例换图片处理
            $handler = (new ImageManager())->make($new_path);
            //整理默认参数
            $width = $height = $img->width();
            $x = 0;
            $y = $i > 0 ? (($i * $height)) : 0;
            //判断高度是否充足
            if ($img->height() < (($i+1) * $height)) {
                //设置y轴
                $y = ($i * $height);
                //设置截取高度
                $height = $img->height() - ($i * $height);
            }
            //裁剪图片
            $handler->crop($width, $height, $x, $y)->save($new_path, $quality, $format);
            //释放内存
            unset($handler);
            //设置新文件地址
            $file_paths[] = $new_path;
        }
        //返回集合
        return $file_paths;
    }


    /**
     * 保存图片文件
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 18:11:13
     * @param $file_path string 文件储存绝对路径
     * @param $quality int 储存质量
     * @return mixed
     */
    public function save($file_path, $quality = 100, $format = null)
    {
        //存入文件
        $this->image->save($file_path, $quality, $format);
        //释放内存
        $this->image = null;
        //返回成功
        return $file_path;
    }

}
