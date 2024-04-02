<?php

namespace Abnermouke\Supports\Frameworks\Laravel\Commands;

use Abnermouke\Supports\Assists\Str;
use Abnermouke\Supports\Library\HelperLibrary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

/**
 * 扩展包支持命令
 */
class SupportsCommands extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'builder:supports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初始化abnermouke/supports';


    /**
     * 构造函数
     * @param $config
     */
    public function __construct($config)
    {
        //引入父级构造
        parent::__construct();
    }

    /**
     * 开始初始化
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 15:02:45
     * @return bool
     * @throws \Exception
     */
    public function handle()
    {
        //询问域名
        $domain = $this->ask('请输入当前项目默认域名，如：baidu.com', 'domain.com');
        //替换文件关键词（configs/project.php）
        $project_php_tpl = str_replace(['domain.com', '__APP_KEY__', '__APP_SECRET__', '__AES_IV__', '__AES_ENCRYPT_KEY__'], [$domain, 'AK'.date('Ymd').strtoupper(Str::random(10)), strtoupper(md5(HelperLibrary::createSn().Str::random())), strtoupper(Str::random(16)), strtoupper(Str::random(16))], file_get_contents(config_path('project.php')));
        //替换内容
        file_put_contents(config_path('project.php'), $project_php_tpl);
        //替换文件关键词（configs/builder.php）
        $builder_php_tpl = str_replace('__APP_VERSION__', rand(10000, 99999), file_get_contents(config_path('builder.php')));
        //替换内容
        file_put_contents(config_path('builder.php'), $builder_php_tpl);
        //设置开放storage
        Artisan::call('storage:link');
        //打印信息
        $this->output->success('构建器初始化完成！');
        //返回成功
        return true;
    }

}
