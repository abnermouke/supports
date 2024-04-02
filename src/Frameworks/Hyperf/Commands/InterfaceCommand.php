<?php

namespace Abnermouke\Supports\Frameworks\Hyperf\Commands;

use Abnermouke\Supports\Assists\File;
use Hyperf\Command\Command;
use Hyperf\Stringable\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Hyperf\Config\config;

/**
 * 接口服务容器创建命令
 */
class InterfaceCommand extends Command
{

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
     */
    public function __construct()
    {
        //注册命令
        parent::__construct('builder:interface');
        //设置介绍
        $this->setDescription('接口服务容器创建命令');
        //获取构建配置信息
        $config = config('builder', []);
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
     * 执行命令
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 02:27:03
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //获取生成文件包统一名称
        $this->tplParams['__NAME__'] = $name = $this->output->ask('请输入当前表名，例如：admins');
        //提示输入表名
        $this->tplParams['__TABLE_NAME__'] = $tableName = $this->output->ask('请输入当前表注释名称并以"表"字结尾，例如：管理员表');
        //提示获取目录结构
        $this->tplParams['__DICTIONARY__'] = $dictionary = (string)$this->output->ask('目录名称，多层级请使用 \ 分割，例如：api (api\v1，多目录使用斜杠分割)');
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
        //输出信息
        $this->output->write('Easy Builder Interfaces Create Success, Make it awesome!', true);
        //返回成功
        return 0;
    }

    /**
     * 获取APP路径地址
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 01:54:41
     * @param $path
     * @return string
     */
    private function getAppPath($path)
    {
        //返回APP目录地址
        return BASE_PATH.'/app/'.$path;
    }

    /**
     * 创建接口信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 02:27:11
     * @return true
     */
    private function makeInterface()
    {
        //整理service目录
        $interfaceServiceDirectory = $this->getAppPath('Interfaces'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']).'/Services');
        //判断目录是否存在
        if (!File::isDirectory($interfaceServiceDirectory)) {
            //创建目录
            File::makeDirectory($interfaceServiceDirectory, 0777, true, true);
        }
        //整理controller目录
        $interfaceControllerDirectory = $this->getAppPath('Interfaces'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']).'/Controllers');
        //判断目录是否存在
        if (!File::isDirectory($interfaceControllerDirectory)) {
            //创建目录
            File::makeDirectory($interfaceControllerDirectory, 0777, true, true);
        }
        //整理路径
        $interfaceServicePath = $this->getAppPath('Interfaces'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']).'/Services/'.$this->tplParams['__LOWER_CASE_NAME__'].'InterfaceService.php');
        $interfaceControllerPath = $this->getAppPath('Interfaces'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']).'/Controllers/'.$this->tplParams['__LOWER_CASE_NAME__'].'Controller.php');
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
     * 写入模版内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 02:27:25
     * @param $path
     * @param $content
     * @return true
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
     * 获取模版内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 02:27:36
     * @param $mode
     * @return array|false|string|string[]
     */
    private function getTplContent($mode = 'service')
    {
        //获取TPL文件信息
        $tplPath = __DIR__.'/../../../../tpl/hyperf/'.strtolower('interface_'.$mode).'.tpl';
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
     * 获取目录
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 02:27:45
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