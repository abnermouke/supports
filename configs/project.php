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

        'api' => env('DOMAIN_OF_WORKSTATION', 'https://api.domain.com'),
        'www' => env('DOMAIN_OF_WWW', 'https://www.domain.com'),
        'h5' => env('DOMAIN_OF_H5', 'https://m.domain.com'),
        'app' => env('DOMAIN_OF_APP', 'https://app.domain.com'),
        'open' => env('DOMAIN_OF_OPEN', 'https://open.domain.com'),
        'workstation' => env('DOMAIN_OF_WORKSTATION', 'https://ws.domain.com'),
        'console' => env('DOMAIN_OF_CONSOLE', 'https://cons.domain.com'),

    ],

    //签名加密信息
    'signature' => [
        'app_key' => '__APP_KEY__',
        'app_secret' => '__APP_SECRET__',
    ],


    //AES加密信息
    'aes' => [
        'iv' => '__AES_IV__',
        'encrypt_key' => '__AES_ENCRYPT_KEY__'
    ],

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
                'visibility' => 'public',            //公有云
            ],
        ],
        //阿里云
        'aliyun' => [
            //阿里云短信
            'sms' => [
                'access_key_id' => '',
                'access_key_secret' => '',
                'sign_name' => '',
                'templates' => [
                    'authenticate' => [
                        'content' => '您的验证码为：${code}，请勿泄露于他人！',
                        'template_id' => 'SMS_XXXXXXXXXX',
                    ]
                ],
            ]
        ],
        //腾讯
        'tencent' => [
            //微信
            'wechat' => [
                //公众号配置
                'official_account' => [
                    'app_id'  => '',
                    'secret'  => '',
                    'token'   => '',
                    'aes_key' => '', // 明文模式请勿填写 EncodingAESKey
                ],
                //小程序
                'mini_program' => [
                    'app_id' => '',
                    'secret' => '',
                    'token' => '',
                    'aes_key' => ''
                ],
                //开放平台-APP移动应用
                'open_platform' => [
                    'app_id' => '', // 开放平台账号的 appid
                    'secret' => '',   // 开放平台账号的 secret
                    'token' => '',  // 开放平台账号的 token
                    'aes_key' => '',   // 明文模式请勿填写 EncodingAESKey
                ],
                //微信支付
                'payment' => [
                    'mch_id' => '',
                    // 商户证书
                    'private_key' => __DIR__ . '/certs/apiclient_key.pem',
                    'certificate' => __DIR__ . '/certs/apiclient_cert.pem',
                    // v3 API 秘钥
                    'secret_key' => '',
                    // v2 API 秘钥
                    'v2_secret_key' => '',
                    // 平台证书：微信支付 APIv3 平台证书，需要使用工具下载
                    // 下载工具：https://github.com/wechatpay-apiv3/CertificateDownloader
                    'platform_certs' => [
                        // 请使用绝对路径
                        // '/path/to/wechatpay/cert.pem',
                    ],
                ],
            ],
        ],
        //快递100
        'kd100' => [
            'secret_key' => '',
            'secret_code' => '',
            'secret_sign' => '',
        ],
        //高德地图
        'amap' => [
            //Web服务API类型KEY
            'web_server_api_key' => '',
        ],
    ],

    //项目其他配置
    'others' => [

        //配置项目其他通用配置（区分目录更为清晰）

    ],

];
