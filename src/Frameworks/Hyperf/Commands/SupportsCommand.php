<?php

namespace Abnermouke\Supports\Frameworks\Hyperf\Commands;

use Abnermouke\Supports\Assists\Framework;
use Abnermouke\Supports\Assists\Str;
use Abnermouke\Supports\Library\HelperLibrary;
use Hyperf\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 扩展包支持命令
 */
class SupportsCommand extends Command
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        //注册命令名称
        parent::__construct('builder:supports');
        //设置描述
        $this->setDescription('初始化abnermouke/supports');
    }

    /**
     * 执行命令
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 11:41:07
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //询问域名
        $domain = $this->ask('请输入当前项目默认域名，如：baidu.com', 'domain.com');
        //替换文件关键词（configs/autoload/project.php）
        $project_php_tpl = str_replace(['//__DEFAULT_USE_USAGE__', 'domain.com', '__APP_KEY__', '__APP_SECRET__', '__AES_IV__', '__AES_ENCRYPT_KEY__'], ['use function Hyperf\Support\env;', $domain, 'AK'.date('Ymd').strtoupper(Str::random(10)), strtoupper(md5(HelperLibrary::createSn().Str::random())), strtoupper(Str::random(16)), strtoupper(Str::random(16))], file_get_contents($this->getConfigPath('project.php')));
        //替换内容
        file_put_contents($this->getConfigPath('project.php'), $project_php_tpl);
        //替换文件关键词（configs/autoload/builder.php）
        $builder_php_tpl = str_replace(['__APP_VERSION__', '__DEFAULT_DATABASE_CONNENCTION__', '__DEFAULT__CACHE_DRIVER__'], [rand(10000, 99999), 'default', 'default'], file_get_contents($this->getConfigPath('builder.php')));
        //替换内容
        file_put_contents($this->getConfigPath('builder.php'), $builder_php_tpl);
        //打印信息
        $this->output->success('构建器初始化完成！');
        //返回成功
        return 0;
    }

    /**
     * 获取配置文件路径
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2024-04-02 11:40:10
     * @param $path
     * @return string
     */
    private function getConfigPath($path)
    {
        //返回Config目录地址
        return BASE_PATH.'/config/autoload/'.$path;
    }

}