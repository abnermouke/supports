<?php

/**
 * Power by abnermouke/supports.
 * User: Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
 * Originate: YunniTec <https://www.yunnitec.com/>
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Customer your project common config settings
    |--------------------------------------------------------------------------
    |
    | The default project settings
    |
    */

    'domains' => [

        // Custom your project domains

    ],

    //签名加密信息
    'signature' => [
        'app_key' => '__APP_KEY__',
        'app_secret' => '__APP_SECRET__',
    ],


    //AES加密信息
    'aes' => [
        'iv' => '__AES_IV__',
        'encrypt_key_suffix' => '__AES_ENCRYPT_KEY__'
    ],


    //高德地图Web服务API类型KEY
    'amap_web_server_api_key' => '',

    //第三方账户信息
    '3rd_passports' => [
        //七牛云
        'qiniu' => [
            //默认配置
            'default' => [
                'domain' => '',                //七牛资源访问域名
                'access_key' => '',
                'access_secret' => '',
                'bucket' => '',
                'visibility' => '',            //公有云
            ],
        ],
    ],

    //项目其他配置
    'others' => [

        //配置项目其他通用配置（区分目录更为清晰）

    ],

];
