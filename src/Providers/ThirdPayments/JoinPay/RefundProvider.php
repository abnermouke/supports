<?php

namespace Abnermouke\Supports\Providers\ThirdPayments\JoinPay;

use Abnermouke\Supports\Library\CodeLibrary;
use Abnermouke\Supports\Providers\ThirdPayments\JoinPay\BasicProvider;

/**
 * 订单退款服务提供者
 */
class RefundProvider extends BasicProvider
{

    /**
     * 构造函数
     * @param array $configs
     */
    public function __construct(array $configs)
    {
        //追加标识
        $configs['__CURRENT_ACTION__'] = '汇聚-订单退款';
        //追加版本号
        $configs['version'] = data_get($configs, 'version', '2.2');
        //配置信息
        $configs = array_merge($configs, ['__RESPONSE_PARAMS__' => [
            'code' => 'rb_Code',
            'code_value' => 0,
            'message' => 'rb_CodeMsg'
        ]]);
        //配置信息
        parent::__construct($configs);
    }

    /**
     * 提交退款
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 17:16:16
     * @param string $out_trade_no
     * @param string $refund_no
     * @param int $refund_amount
     * @param string $notify_uri
     * @param string $refund_reason
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function submit(string $out_trade_no, string $refund_no, int $refund_amount, string $notify_uri, string $refund_reason = '')
    {
        //整理公共预下单参数
        $params = [
            'q1_version' => $this->configs['version'],
            'p1_MerchantNo' => $this->configs['merchant_no'],
            'p2_OrderNo' => $out_trade_no,
            'p3_RefundOrderNo' => $refund_no,
            'p4_RefundAmount' => $refund_amount / 100,
            'p5_RefundReason' => $refund_reason,
            'p6_NotifyUrl' => $notify_uri,
        ];
        //生成签名
        $params['hmac'] = $this->getHmcMd5Signature($params);
        //发起请求
        $result = $this->httpRequest('/trade/refund.action', $params);
        //验证返回结果
        if (!$result || (int)$result['rb_Code'] !== 100) {
            //响应结果
            return $this->response(CodeLibrary::WITH_DO_NOT_ALLOW_STATE, data_get($result, 'rb_CodeMsg', 'UNKNOWN'), $result);
        }
        //返回成功
        return $this->response(CodeLibrary::CODE_SUCCESS, '操作成功', [
            'rawData' => $result,
            'result' => [
                'state' => (int)$result['ra_Status'] === 100,
                'amount' => (int)((float)$result['r4_RefundAmount'] * 100),
                'stream_no' => $result['r5_RefundTrxNo'],
            ]
        ]);
    }


}
