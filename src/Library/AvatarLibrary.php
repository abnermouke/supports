<?php

namespace Abnermouke\Supports\Library;

use Abnermouke\Supports\Frameworks\Laravel\Library\StorageFileLibrary;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

/**
 * 头像生成藏类
 */
class AvatarLibrary
{

    //基础信息
    private $image;
    private int $height = 200;
    private string $background = '#FFFFFF';
    private string $color = '#000000';
    private string $ttf;

    /**
     * 构造函数
     * @param int $height
     * @param string $bacground
     * @param string $color
     */
    public function __construct(int $height = 200, string $bacground = '#F7F7F7', string $color = '#333333')
    {
        //设置基本信息
        $this->height = $height;
        //设置默认配置
        $this->background($bacground)->color($color);
    }

    /**
     * 创建实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-07-26 23:30:23
     * @param string $ttf
     * @param int $height
     * @return AvatarLibrary
     */
    public static function make(string $ttf, int $height = 200)
    {
        //生成示例
        return (new AvatarLibrary($height))->ttf($ttf);
    }

    /**
     * 设置字体文件
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-07-26 23:30:31
     * @param string $ttf
     * @return $this
     */
    public function ttf(string $ttf): static
    {
        //保存文字字体
        $this->ttf = $ttf;
        //返回当前实例
        return $this;
    }

    /**
     * 设置背景色
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-07-26 23:30:41
     * @param string $background
     * @return $this
     */
    public function background(string $background = '#F8F8F8'): static
    {
        //保存背景颜色
        $this->background = $background;
        //返回当前实例
        return $this;
    }

    /**
     * 设置文字颜色
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-07-26 23:30:48
     * @param string $color
     * @return $this
     */
    public function color(string $color = '#333333'): static
    {
        //保存文字颜色
        $this->color = $color;
        //返回当前实例
        return $this;
    }

    /**
     * 生成文字头像
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-07-26 23:08:46
     * @param string $name
     * @return $this
     */
    public function name(string $name): static
    {
        //计算文字大小
        $font_size = $this->height / mb_strlen($name) / (mb_strlen($name) <= 4 ? 1.5 : 1.1);

        //添加文字
        $this->image = ImageManager::imagick()->create($this->height, $this->height)->fill($this->background)->text($name, $this->height / 2, $this->height / 2, function ($font) use ($font_size) {
            $font->filename($this->ttf);
            $font->size($font_size);
            $font->color($this->color);
            $font->align('center');
            $font->valign('middle');
        });

        //返回当前实例
        return $this;
    }

    /**
     * 保存图片信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-07-26 23:13:42
     * @param string $storage_name
     * @param int $quality
     * @param string $storage_disk
     * @param bool $force_merge
     * @return string
     */
    public function save(string $storage_name, int $quality = 100, string $storage_disk = 'public', bool $force_merge = true): string
    {
        //检测地址信息
        $file = StorageFileLibrary::check($storage_name, $storage_disk, $force_merge);

        //保存文件
        $this->image->save($file['storage_path'], quality: $quality);

        //释放内存
        $this->image = null;

        //返回信息
        return Storage::disk($storage_disk)->url($storage_name);
    }


}
