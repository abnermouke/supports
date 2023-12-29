<?php

namespace Abnermouke\Supports\Providers\ThirdPayments\JoinPay\Fastpay;

use Abnermouke\Supports\Providers\ThirdPayments\JoinPay\BasicProvider;

/**
 * 协议支付服务
 */
class AgreementProvider extends BasicProvider
{

    /**
     * 构造函数
     * @param array $configs
     */
    public function __construct(array $configs)
    {
        //追加标识
        $configs['__CURRENT_ACTION__'] = '汇聚-快捷协议支付';
        //设置请求链接
        $configs['base_uri'] = 'https://api.joinpay.com/';
        //引入父级构造
        parent::__construct($configs);
    }
    
    


    

}
