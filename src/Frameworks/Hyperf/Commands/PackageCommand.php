<?php

namespace Abnermouke\Supports\Frameworks\Hyperf\Commands;

use Abnermouke\Supports\Assists\File;
use Hyperf\Command\Command;
use Hyperf\Stringable\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Hyperf\Config\config;

/**
 * 资源包生成命令
 */
class PackageCommand extends Command
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
        '__CHARSET__' => 'utf8mb4',
        '__ENGINE__' => 'innodb',
        '__DB_PREFIX__' => '',
        '__DATA_CACHE_NAME__' => '',
        '__DATA_CACHE_EXPIRE_SECOND__' => 0,
        '__DATA_CACHE_DRIVER__' => 'default',
        '__DB_CONNECTION__' => '',
        '__DICTIONARY__' => ''
    ];

    /**
     * 构造函数
     */
    public function __construct()
    {
        //注册命令名称
        parent::__construct('builder:package');
        //设置命令描述
        $this->setDescription('资源包生成命令');
        //获取构建配置信息
        $config = config('builder', []);
        //初始化基本配置
        $default_params = [
            '__DATE__' => date('Y-m-d'),
            '__TIME__' => date('H:i:s'),
            '__AUTHOR__' => data_get($config, 'author', 'Abnermouke'),
            '__AUTHOR_CONTACT_EMAIL' => data_get($config, 'author_email', 'abnermouke@outlook.com'),
            '__ORIGINATE__' => data_get($config, 'original', 'Yunni Network Technology Co., Ltd. '),
            '__DB_CONNECTION__' => data_get($config, 'database_connection', 'default'),
            '__DATA_CACHE_DRIVER__' => data_get($config, 'cache_driver', 'default'),
        ];
        //初始化配置
        $this->tplParams = array_merge($this->tplParams, $default_params);
    }

    /**
     * 开始处理
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 11:00:50
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        //获取生成文件包统一名称
        $this->tplParams['__NAME__'] = $this->tplParams['__MIGRATION_NAME__'] = $name = $this->output->ask('请输入当前表名，例如：admins');
        //提示输入表名
        $this->tplParams['__TABLE_NAME__'] = $tableName = $this->output->ask('请输入当前表注释名称并以"表"字结尾，例如：用户基本信息表');
        //提示获取目录结构
        $this->tplParams['__DICTIONARY__'] = $dictionary = (string)$this->output->ask('多项目部署时如需对各服务文件进行分开部署请输入目录名称，多层级请使用 \ 分割，例如：www (www\home)');
        //提示设置数据库前缀
        $this->tplParams['__DB_PREFIX__'] = $dbPrefix =(string)$this->output->ask('请设置数据库表前缀，如数据库表存在统一前缀，请输入前缀，例如：'.config('builder.database_prefix', 'system_'), config('builder.database_prefix', ''));
        //初始化数据库前缀信息
        $this->tplParams['__DB_PREFIX__'] = Str::finish($dbPrefix, '_');
        //整理驼峰名称
        $this->tplParams['__CASE_NAME__'] = $this->tplParams['__MIGRATION_CASE_NAME_'] = $caseName = Str::studly($name);
        //整理驼峰名称（小写）
        $this->tplParams['__LOWER_CASE_NAME__'] = Str::singular($caseName);
        //整理驼峰目录名称
        $this->tplParams['__DICTIONARY__'] = data_get($this->tplParams, '__DICTIONARY__', false) ? Str::start($this->caseDictionary($this->tplParams['__DICTIONARY__']), '\\') : '';
        //匹配数据名
        $ret = preg_match('~(.*)表~Uuis', $tableName, $matched);
        //初始化数据名
        $this->tplParams['__DATA_NAME__'] = intval($ret) >= 1 ? $matched[1] : $tableName;
        //询问获取数据库链接信息
        $this->tplParams['__DB_CONNECTION__'] = $this->choice('请选择当前数据查询时使用的表链接信息！', array_keys(config('databases')), 'default');
        //生成model
        $this->makeModel();
        //生成数据仓库
        $this->makeRepository();
        //生成服务容器
        $this->makeService();
        //询问是否生成数据缓存
        if ($this->confirm('是否生成数据缓存文件？', true)) {
            //设置基础缓存名
            $this->tplParams['__DATA_CACHE_NAME__'] = $this->ask('您可以自定义当前数据缓存名，默认为：[ '. (($dictionary ? strtolower(str_replace('\\', ':', $dictionary)).':' : '').$name.'_data_cache').' ]，如需更改，请输入您要使用的缓存名！', (($dictionary && !empty($dictionary) ? strtolower(str_replace('\\', ':', $dictionary)).':' : '').$name.'_data_cache'));
            //设置缓存过期时间，随机1小时-一天
            $this->tplParams['__DATA_CACHE_EXPIRE_SECOND__'] = $this->ask('您可以自定义数据缓存过期时间（单位：s）,系统将默认设定为 1 小时至一天的随机时间过期，您也可以自定义，0 为永远不过期，请输入当前数据缓存的过期时间！', (string)rand(3600, 86400));
            //生成数据缓存文件
            $this->makeDataCache();
        }
        //输出信息
        $this->output->write('Abnermouke Supports Packages Create Success, Make it awesome!', true);
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
     * 创造缓存
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 15:19:09
     * @return true
     */
    private function makeDataCache()
    {
        //询问获取数据库链接信息
        $this->tplParams['__DATA_CACHE_DRIVER__'] = $this->choice('请选择当前缓存链接时使用的链接信息！', array_keys(config('cache')), 'default');
        //整理目录
        $dataCacheDirectory = $this->getAppPath('Handler/Cache/Data'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']));
        //判断目录是否存在
        if (!File::isDirectory($dataCacheDirectory)) {
            //创建目录
            File::makeDirectory($dataCacheDirectory, 0777, true, true);
        }
        //整理路径
        $dataCachePath = $this->getAppPath('Handler/Cache/Data'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']).'/'.$this->tplParams['__LOWER_CASE_NAME__'].'CacheHandler.php');
        //判断文件地址
        if (file_exists($dataCachePath) && !$this->confirm('数据缓存 ['.$dataCachePath.'] 已存在，是否覆盖写入？')) {
            //直接返回
            return true;
        }
        //获取模版内容
        $content = $this->getTplContent('data_cache');
        //内容存在
        if (!empty($content)) {
            //设置内容
            $this->putContent($dataCachePath, $content);
        }
        return true;
    }

    /**
     * 创建模型文件
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 11:00:15
     * @return true
     */
    private function makeModel()
    {
        //整理目录
        $modelDirectory = $this->getAppPath('Models'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']));
        //判断目录是否存在
        if (!File::isDirectory($modelDirectory)) {
            //创建目录
            File::makeDirectory($modelDirectory, 0777, true, true);
        }
        //整理路径
        $modelPath = $this->getAppPath('Models'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']).'/'.$this->tplParams['__CASE_NAME__'].'.php');
        //判断文件地址
        if (file_exists($modelPath) && !$this->confirm('数据模型 ['.$modelPath.'] 已存在，是否覆盖写入？')) {
            //直接返回
            return true;
        }
        //获取模版内容
        $content = $this->getTplContent('model');
        //内容存在
        if (!empty($content)) {
            //设置内容
            $this->putContent($modelPath, $content);
        }
        return true;
    }

    /**
     * 创建服务容器
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 11:00:04
     * @return true
     */
    private function makeService()
    {
        //整理目录
        $serviceDirectory = $this->getAppPath('Services'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']));
        //判断目录是否存在
        if (!File::isDirectory($serviceDirectory)) {
            //创建目录
            File::makeDirectory($serviceDirectory, 0777, true, true);
        }
        //整理路径
        $servicePath = $this->getAppPath('Services'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']).'/'.$this->tplParams['__LOWER_CASE_NAME__'].'Service.php');
        //判断文件地址
        if (file_exists($servicePath) && !$this->confirm('服务容器 ['.$servicePath.'] 已存在，是否覆盖写入？')) {
            //直接返回
            return true;
        }
        //获取模版内容
        $content = $this->getTplContent('service');
        //内容存在
        if (!empty($content)) {
            //设置内容
            $this->putContent($servicePath, $content);
        }
        return true;
    }

    /**
     * 创建数据仓库
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 10:59:57
     * @return true
     */
    private function makeRepository()
    {
        //整理目录
        $repositoryDirectory = $this->getAppPath('Repository'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']));
        //判断目录是否存在
        if (!File::isDirectory($repositoryDirectory)) {
            //创建目录
            File::makeDirectory($repositoryDirectory, 0777, true, true);
        }
        //整理路径
        $repositoryPath = $this->getAppPath('Repository'.str_replace('\\', '/', $this->tplParams['__DICTIONARY__']).'/'.$this->tplParams['__LOWER_CASE_NAME__'].'Repository.php');
        //判断文件地址
        if (file_exists($repositoryPath) && !$this->confirm('数据仓库 ['.$repositoryPath.'] 已存在，是否覆盖写入？')) {
            //直接返回
            return true;
        }
        //获取模版内容
        $content = $this->getTplContent('repository');
        //内容存在
        if (!empty($content)) {
            //设置内容
            $this->putContent($repositoryPath, $content);
        }
        return true;
    }

    /**
     * 写入内容
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 10:59:48
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
     * @Time 2024-04-02 10:59:39
     * @param $mode
     * @return array|false|string|string[]
     */
    private function getTplContent($mode = 'migration')
    {
        //获取TPL文件信息
        $tplPath = __DIR__.'/../../../../tpl/hyperf/'.strtolower($mode).'.tpl';
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
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 10:59:27
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