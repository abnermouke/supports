<?php

/**
 * Power by abnermouke/supports.
 * User: Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
 * Originate: YunniTec <https://www.yunnitec.com/>
 */

return [

    /*
  |--------------------------------------------------------------------------
  | Database default setting and Basic setting
  |--------------------------------------------------------------------------
  |
  | The default database settings
  |
  */

    'database_prefix' => 's_',                                       // 默认数据库表前缀 (为方便辨识，请加上分隔符'_')
    'database_charset' => 'utf8mb4',                                // Default database charset (proposal：utf8mb4)
    'database_engine' => 'innodb',                                  // Default database engine (proposal：innodb)

    // 默认数据库链接
    // Laravel (默认：mysql < 如需指定链接，请前往 config/database.php 添加 >)
    // Hyperf (默认：default < 如需指定链接，请前往 config/autoload/databases.php 添加 >)
    'database_connection' => '__DEFAULT_DATABASE_CONNENCTION__',

    // 默认缓存驱动
    // Laravel (默认：file  < 可选：file， redis， mongodb等，redis、mongodb需单独安装/配置>)
    // Hyperf (默认：default，其他需自行配置)
    'cache_driver' => '__DEFAULT__CACHE_DRIVER__',

    //默认应用（项目）版本号
    'app_version' => '__APP_VERSION__',

    // Default builder packages
    'default_builder' => [
        'migration' => true,           //default build migration
        'data_cache' => true,           //default build data cache handler
    ],


    /*
   |--------------------------------------------------------------------------
   | Author config
   |--------------------------------------------------------------------------
   |
   | The base config for author
   |
   */

    'author' => 'Abnermouke',
    'author_email' => 'abnermouke@outlook.com',
    'original' => 'Chongqing Yunni Network Technology Co., Ltd',


];
