<?php

namespace Abnermouke\Supports\Assists;

/**
 * 本地模块方法集合
 */
class File
{

    /**
     * 获取目录下目录
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 17:18:08
     * @param $directory
     * @return array
     */
    public static function dictionaries($directory)
    {
        //整理目录列表
        $dictionaries = [];
        //判断是否为目录
        if (static::isDirectory($directory)) {
            //扫描目录下所有目录
            if ($scans = scandir($directory)) {
                //循环扫描结果
                foreach ($scans as $k => $dirname) {
                    //判断是否为特殊目录
                    if ($dirname !== '.' && $dirname !== '..') {
                        //整理文件路径
                        $dir_path = $directory.DIRECTORY_SEPARATOR.$dirname;
                        //判断是否为文件
                        if (static::isDirectory($dir_path)) {
                            //整理信息
                            $dictionaries[] = $dir_path;
                        }
                    }
                    //释放内存
                    unset($scans[$k]);
                }
            }
        }
        //返回文件列表
        return $dictionaries;
    }

    /**
     * 获取目录下文件
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 17:12:08
     * @param $directory
     * @return array
     */
    public static function files($directory)
    {
        //整理文件列表
        $files = [];
        //判断是否为目录
        if (static::isDirectory($directory)) {
            //扫描目录下所有目录
            if ($scans = scandir($directory)) {
                //循环扫描结果
                foreach ($scans as $k => $filename) {
                    //判断是否为特殊目录
                    if ($filename !== '.' && $filename !== '..') {
                        //整理文件路径
                        $file_path = $directory.DIRECTORY_SEPARATOR.$filename;
                        //判断是否为文件
                        if (static::isFile($file_path)) {
                            //整理信息
                            $files[] = static::infos($file_path);
                        }
                    }
                    //释放内存
                    unset($scans[$k]);
                }
            }
        }
        //返回文件列表
        return $files;
    }

    /**
     * 判断文件/目录是否存在
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:51:06
     * @param $path string 文件或目录绝对路径
     * @return bool
     */
    public static function exists($path)
    {
        return file_exists($path);
    }

    /**
     * 判断文件或目录是否丢失
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:51:18
     * @param $path string 文件或目录绝对路径
     * @return bool
     */
    public static function missing($path)
    {
        return !static::exists($path);
    }

    /**
     * 获取文件HASH
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:52:42
     * @param $path string 文件绝对路径
     * @param $algorithm string 标识
     * @return false|string
     */
    public static function hash($path, $algorithm = 'md5')
    {
        return hash_file($algorithm, $path);
    }

    /**
     * 写入文件内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:53:34
     * @param $path string 文件绝对路径
     * @param $contents string 写入内容
     * @param $lock bool 是否锁定
     * @return false|int
     */
    public static function put($path, $contents, $lock = false)
    {
        return file_put_contents($path, $contents, $lock ? LOCK_EX : 0);
    }

    /**
     * 追加文件内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:54:49
     * @param $path string 文件绝对路径
     * @param $content string 追加内容
     * @return false|int
     */
    public static function append($path, $content)
    {
        return file_put_contents($path, $content, FILE_APPEND);
    }

    /**
     * 移动文件
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:55:27
     * @param $path string 文件绝对路径
     * @param $path string 目标文件绝对路径
     * @return bool
     */
    public static function move($path, $target)
    {
        return rename($path, $target);
    }

    /**
     * 复制文件
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:56:38
     * @param $path string 文件绝对路径
     * @param $path string 目标文件绝对路径
     * @return bool
     */
    public static function copy($path, $target)
    {
        return copy($path, $target);
    }

    /**
     * 获取文件名称
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:57:15
     * @param $path string 文件绝对路径
     * @return array|string|string[]
     */
    public static function name($path)
    {
        return pathinfo($path, PATHINFO_FILENAME);
    }

    /**
     * 获取文件基础路径名称
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:57:57
     * @param $path string 文件绝对路径
     * @return array|string|string[]
     */
    public static function basename($path)
    {
        return pathinfo($path, PATHINFO_BASENAME);
    }

    /**
     * 获取文件目录名称
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:58:12
     * @param $path string 文件绝对路径
     * @return array|string|string[]
     */
    public static function dirname($path)
    {
        return pathinfo($path, PATHINFO_DIRNAME);
    }

    /**
     * 获取文件后缀
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:58:32
     * @param $path string 文件绝对路径
     * @return array|string|string[]
     */
    public static function extension($path)
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * 获取文件类型
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:59:01
     * @param $path string 文件绝对路径
     * @return false|string
     */
    public static function type($path)
    {
        return filetype($path);
    }

    /**
     * 获取文件mine-type
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:59:15
     * @param $path string 文件绝对路径
     * @return false|string
     */
    public static function mimeType($path)
    {
        return finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);
    }

    /**
     * 获取文件大小
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:59:33
     * @param $path string 文件绝对路径
     * @return false|int
     */
    public static function size($path)
    {
        return filesize($path);
    }

    /**
     * 获取文件最后修改时间
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 16:00:03
     * @param $path string 文件绝对路径
     * @return false|int
     */
    public static function lastModified($path)
    {
        return filemtime($path);
    }

    /**
     * 判断是否是个目录
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 16:00:24
     * @param $directory string 目录绝对路径
     * @return bool
     */
    public static function isDirectory($directory)
    {
        return is_dir($directory);
    }

    /**
     * 判断是否是个文件
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 16:00:56
     * @param $file string 文件绝对路径
     * @return bool
     */
    public static function isFile($file)
    {
        return is_file($file);
    }

    /**
     * 创建目录
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 16:03:50
     * @param $directory string 目录绝对路径
     * @param $mode int 权限编码
     * @param $recursive bool 是否循环创建
     * @param $force bool 是否强制覆盖
     * @return bool
     */
    public static function makeDirectory($path, $mode = 0755, $recursive = false, $force = false)
    {
        if ($force) {
            return @mkdir($path, $mode, $recursive);
        }

        return mkdir($path, $mode, $recursive);
    }

    /**
     * 检查目录情况
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 21:34:27
     * @param $path
     * @return mixed
     */
    public static function checkDictionary($path)
    {
        //获取目录
        $dictionary = static::dirname($path);
        //判断是否为目录
        if (static::missing($dictionary) || !static::isDirectory($dictionary)) {
            //创建目录
            static::makeDirectory($dictionary, 0755, true);
        }
        //返回信息
        return $path;
    }

    /**
     * 删除指定文件
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 21:50:16
     * @param $paths string|array 文件绝对路径（可为数组集合）
     * @return bool
     */
    public static function delete($paths)
    {
        $paths = is_array($paths) ? $paths : func_get_args();

        $success = true;

        foreach ($paths as $path) {
            try {
                if (@unlink($path)) {
                    clearstatcache(false, $path);
                } else {
                    $success = false;
                }
            } catch (ErrorException $e) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * 获取文件内容信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 21:48:34
     * @param $path
     * @return array
     */
    public static function infos($path)
    {
        //整理文件信息
        return [
            'path' => $path,
            'name' => static::name($path),
            'basename' => static::basename($path),
            'dirname' => static::dirname($path),
            'extension' => static::extension($path),
            'type' => static::type($path),
            'mime_type' => static::mimeType($path),
            'size' => static::size($path),
            'time' => static::lastModified($path),
        ];
    }



}
