<?php

namespace Abnermouke\Supports\Frameworks\Laravel;

use Abnermouke\Supports\Frameworks\Laravel\Commands\InterfaceCommands;
use Abnermouke\Supports\Frameworks\Laravel\Commands\PackageCommands;
use Abnermouke\Supports\Frameworks\Laravel\Commands\SupportsCommands;
use Illuminate\Support\ServiceProvider;

class SupportsServiceProvider extends ServiceProvider
{

    /**
     * 注册服务
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 14:50:59
     */
    public function register()
    {
        //引入配置
        $this->app->singleton('command.builder.package', function ($app) {
            //返回实例
            return new PackageCommands($app['config']['builder']);
        });
        //引入配置
        $this->app->singleton('command.builder.supports', function ($app) {
            //返回实例
            return new SupportsCommands($app['config']);
        });
        //引入配置
        $this->app->singleton('command.builder.interface', function ($app) {
            //返回实例
            return new InterfaceCommands($app['config']['builder']);
        });
    }

    /**
     * Bootstrap services.
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-26 14:51:06
     */
    public function boot()
    {
        // 发布配置文件
        $this->publishes([
            __DIR__.'/../../../configs/builder.php' => config_path('builder.php'),
            __DIR__.'/../../../configs/project.php' => config_path('project.php'),
            __DIR__.'/../../../helpers/laravel/auth.php' => app_path('Helpers/auth.php'),
            __DIR__.'/../../../helpers/laravel/response.php' => app_path('Helpers/response.php'),
            __DIR__.'/../../../helpers/projects.php' => app_path('Helpers/projects.php'),
            __DIR__.'/Commands/TestCommand.php' => app_path('Console/Commands/TestCommand.php'),
            __DIR__ . '/Middlewares/BaseSupportsMiddleware.php' => app_path('Http/Middleware/Abnermouke/BaseSupportsMiddleware.php'),
        ]);
        // 注册配置
        $this->commands('command.builder.package');
        $this->commands('command.builder.supports');
        $this->commands('command.builder.interface');
    }

}
