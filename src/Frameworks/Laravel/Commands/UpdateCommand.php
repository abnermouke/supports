<?php

namespace App\Console\Commands\Application;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '应用更新逻辑';

    /**
     * 执行命令
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 16:45:50
     * @return int
     */
    public function handle()
    {
        //初始化信息
        set_time_limit(0);
        ini_set('memory_limit', '5124M');
        //清空非必要缓存
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        //刷新migration
        Artisan::call('migrate:refresh', ['--path' => '/database/migrations/fillings', '--force' => true]);
        //设置配置缓存
        Artisan::call('config:cache');
        //判断是否正式环境
        if (config('app.env', 'dev') === 'production') {
            //设置路由与视图缓存
            Artisan::call('route:cache');
            Artisan::call('view:cache');
        }
        //执行前置操作
        $this->beforeHandle();
        //创建默认数据
        $this->defaultData();
        //执行后置操作
        $this->afterHandle();
        //执行成功
        $this->output->success('应用更新成功');
        //返回成功
        return Command::SUCCESS;
    }

    /**
     * 前置操作
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 16:46:03
     * @return true
     */
    public function beforeHandle()
    {

        //执行完成
        return true;
    }

    /**
     * 后置操作
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 16:46:08
     * @return true
     */
    public function afterHandle()
    {

        //执行完成
        return true;
    }

    /**
     * 默认数据创建
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-09-18 16:46:12
     * @return true
     */
    public function defaultData()
    {

        //执行完成
        return true;
    }
}
