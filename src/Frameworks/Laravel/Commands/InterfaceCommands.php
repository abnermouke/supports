<?php

namespace Abnermouke\Supports\Frameworks\Laravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * 接口服务容器创建命令
 */
class InterfaceCommands extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'builder:interface {name} {--desc=} {--dictionary=} {--package_dictionary=} {--ccf}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Abnermouke Support
                              {name: 对应表名，不含表前缀，如：admins}
                              {--desc: 表注释并以"表"字结尾，例如：管理员表}
                              {--dictionary: 目录名称，多层级请使用 \ 分割，例如：api (api\v1，多目录使用斜杠分割)}
                              {--package_dictionary: package资源生成时使用的目录名称，多层级请使用 \ 分割，例如：www (www\home，多目录使用分号包裹)}
                              {--ccf: 是否强制生成控制台系列方法等}
                            ';

    /**
     * 初始化模版参数
     * @var array
     */
    private $tplParams = [
        '__NAME__' => '',
        '__TABLE_NAME__' => '',
        '__CASE_NAME__' => '',
        '__DATA_NAME__' => '',
        '__LOWER_CASE_NAME__' => '',
        '__AUTHOR__' => '',
        '__AUTHOR_CONTACT_EMAIL' => '',
        '__ORIGINATE__' => '',
        '__DATE__' => '',
        '__TIME__' => '',
        '__DICTIONARY__' => ''
    ];


    /**
     * 构造函数
     * @param $config
     */
    public function __construct($config)
    {
        //引入父级构造
        parent::__construct();
        //初始化基本配置
        $default_params = [
            '__DATE__' => date('Y-m-d'),
            '__TIME__' => date('H:i:s'),
            '__AUTHOR__' => data_get($config, 'author', 'Abnermouke'),
            '__AUTHOR_CONTACT_EMAIL' => data_get($config, 'author_email', 'abnermouke@outlook.com'),
            '__ORIGINATE__' => data_get($config, 'original', 'Yunni Network Technology Co., Ltd. '),
        ];
        //初始化配置
        $this->tplParams = array_merge($this->tplParams, $default_params);
    }

    /**
     * 开始处理
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 23:22:30
     */
    public function handle()
    {
        //获取生成文件包统一名称
        $this->tplParams['__NAME__'] = $name = $this->argument('name');
        //提示输入表名
        $this->tplParams['__TABLE_NAME__'] = $tableName = ($this->option('desc') ? $this->option('desc') : $this->output->ask('请输入当前表注释名称并以"表"字结尾，例如：管理员表'));
        //提示获取目录结构
        $this->tplParams['__DICTIONARY__'] = $dictionary = ($this->option('dictionary') ? $this->option('dictionary') : (string)$this->output->ask('目录名称，多层级请使用 \ 分割，例如：api (api\v1，多目录使用斜杠分割)'));
        //整理驼峰名称
        $this->tplParams['__CASE_NAME__'] = $caseName = Str::studly($name);
        //整理驼峰名称（小写）
        $this->tplParams['__LOWER_CASE_NAME__'] = Str::singular($caseName);
        //整理驼峰目录名称
        $this->tplParams['__DICTIONARY__'] = data_get($this->tplParams, '__DICTIONARY__', false) ? Str::start($this->caseDictionary($this->tplParams['__DICTIONARY__']), '\\') : '';
        //匹配数据名
        $ret = preg_match('~(.*)表~Uuis', $tableName, $matched);
        //初始化数据名
        $this->tplParams['__DATA_NAME__'] = $dataName = intval($ret) >= 1 ? $matched[1] : $tableName;
        //生成服务容器
        $this->makeInterface();
        //生成钩子
        $this->makeHook();
        //输出信息
        $this->output->write('Easy Builder Interfaces Create Success, Make it awesome!', true);
    }

    /**
     * 生成服务容器
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 23:22:23
     * @return bool
     */
    private function makeInterface()
    {
        //整理service目录
        $interfaceServiceDirectory = app_path('Interfaces'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']).'/Services');
        //判断目录是否存在
        if (!File::isDirectory($interfaceServiceDirectory)) {
            //创建目录
            File::makeDirectory($interfaceServiceDirectory, 0777, true, true);
        }
        //整理controller目录
        $interfaceControllerDirectory = app_path('Interfaces'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']).'/Controllers');
        //判断目录是否存在
        if (!File::isDirectory($interfaceControllerDirectory)) {
            //创建目录
            File::makeDirectory($interfaceControllerDirectory, 0777, true, true);
        }
        //整理路径
        $interfaceServicePath = app_path('Interfaces'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']).'/Services/'.$this->tplParams['__LOWER_CASE_NAME__'].'InterfaceService.php');
        $interfaceControllerPath = app_path('Interfaces'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']).'/Controllers/'.$this->tplParams['__LOWER_CASE_NAME__'].'Controller.php');
        //判断文件地址
        if (file_exists($interfaceServicePath) && !$this->confirm('服务逻辑容器 ['.$interfaceServicePath.'] 已存在，是否覆盖写入？')) {
            //直接返回
            return true;
        }
        //判断文件地址
        if (file_exists($interfaceControllerPath) && !$this->confirm('服务控制器 ['.$interfaceControllerPath.'] 已存在，是否覆盖写入？')) {
            //直接返回
            return true;
        }
        //获取模版内容（service）
        $content = $this->getTplContent('service');
        //内容存在
        if (!empty($content)) {
            //设置内容
            $this->putContent($interfaceServicePath, $content);
        }
        //获取模版内容（controller）
        $content = $this->getTplContent('controller');
        //内容存在
        if (!empty($content)) {
            //设置内容
            $this->putContent($interfaceControllerPath, $content);
        }
        return true;
    }

    /**
     * 创建钩子
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2025-01-05 15:12:01
     * @return true
     */
    private function makeHook()
    {
        //整理钩子目录
        $hookeDirectory = app_path('Hooks'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']));
        //判断目录是否存在
        if (!File::isDirectory($hookeDirectory)) {
            //创建目录
            File::makeDirectory($hookeDirectory, 0777, true, true);
        }
        //整理路径
        $hookPath = app_path('Hooks'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']).'/'.$this->tplParams['__LOWER_CASE_NAME__'].'Hook.php');
        //判断文件地址
        if (file_exists($hookPath) && !$this->confirm('钩子模版 ['.$hookPath.'] 已存在，是否覆盖写入？')) {
            //直接返回
            return true;
        }
        //获取模版内容（service）
        $content = $this->getTplContent('hook');
        //内容存在
        if (!empty($content)) {
            //设置内容
            $this->putContent($hookPath, $content);
        }
        return true;
    }

    /**
     * 设置文件内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 23:22:14
     * @param $path
     * @param $content
     * @return bool
     */
    private function putContent($path, $content)
    {
        //打开文件
        $fp = fopen($path, 'w+');
        //写入文件
        fwrite($fp, $content);
        //关闭写入事件
        fclose($fp);
        //判断文件内容
        if (!file_exists($path)) {
            //抛出错误
            $this->output->warning('文件写入失败：'.$path);
        }
        //返回成功
        return true;
    }

    /**
     * 根据内容渲染模版获取详细模版内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 23:22:05
     * @param $mode
     * @return array|false|string|string[]
     */
    private function getTplContent($mode = 'service')
    {
        //获取TPL文件信息
        $tplPath = __DIR__.'/../../../../tpl/laravel/'.strtolower('interface_'.$mode).'.tpl';
        //判断模版信息是否存在
        if (!file_exists($tplPath)) {
            //抛出错误
            $this->output->warning('缺少TPL：'.$tplPath);
            //直接返回
            return false;
        }
        //获取内容
        $content = file_get_contents($tplPath);
        //循环参数
        foreach ($this->tplParams as $item => $value) {
            //替换参数
            $content = str_replace('{'.$item.'}', $value, $content);
        }
        //返回模版内容
        return $content;
    }

    /**
     * 设置多层级目录结构
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 23:21:56
     * @param $dictionary
     * @return string
     */
    private function caseDictionary($dictionary)
    {
        //拆分目录
        $dictionaries = explode('\\', $dictionary);
        //循环目录信息
        foreach ($dictionaries as $k => $dict) {
            //设置信息
            $dictionaries[$k] = Str::studly($dict);
        }
        //返回信息
        return implode('\\', $dictionaries);
    }

}
