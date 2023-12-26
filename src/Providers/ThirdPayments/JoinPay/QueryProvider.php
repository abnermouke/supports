<?php

namespace Abnermouke\Supports\Providers\ThirdPayments\JoinPay;

use Abnermouke\Supports\Library\CodeLibrary;
use Abnermouke\Supports\Providers\ThirdPayments\JoinPay\BasicProvider;

/**
 * 订单查询服务提供者
 */
class QueryProvider extends BasicProvider
{

    /**
     * 构造函数
     * @param array $configs
     */
    public function __construct(array $configs)
    {
        //追加标识
        $configs['__CURRENT_ACTION__'] = '汇聚-订单查询';
        //配置信息
        parent::__construct($configs);
    }

    /**
     * 根据商户单号查询支付记录
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 16:52:24
     * @param string $out_trade_no
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function payment(string $out_trade_no)
    {
        //追加标识
        $configs['__CURRENT_ACTION__'] = '汇聚-订单支付查询';
        //整理公共预下单参数
        $params = [
            'p0_Version' => $this->configs['version'],
            'p1_MerchantNo' => $this->configs['merchant_no'],
            'p2_OrderNo' => $out_trade_no,
        ];
        //生成签名
        $params['hmac'] = $this->getHmcMd5Signature($params);
        //发起请求
        $result = $this->httpRequest('/trade/queryOrder.action', $params);
        //验证返回结果
        if ((int)$result['ra_Code'] !== 100) {
            //响应结果
            return $this->response(CodeLibrary::WITH_DO_NOT_ALLOW_STATE, $result['rb_CodeMsg'], $result);
        }
        //返回成功
        return $this->response(CodeLibrary::CODE_SUCCESS, '操作成功', [
            'rawData' => $result,
            'result' => [
                'state' => (int)$result['ra_Status'] === 100,
                'amount' => (int)((float)$result['r3_Amount'] * 100),
                'out_trade_no' => $out_trade_no,
            ]
        ]);
    }

    /**
     * 查询退款记录
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 17:08:09
     * @param string $refund_no
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refund(string $refund_no)
    {
        //追加标识
        $configs['__CURRENT_ACTION__'] = '汇聚-订单退款查询';
        //整理公共预下单参数
        $params = [
            'p0_Version' => $this->configs['version'],
            'p1_MerchantNo' => $this->configs['merchant_no'],
            'p2_RefundOrderNo' => $refund_no,
        ];
        //生成签名
        $params['hmac'] = $this->getHmcMd5Signature($params);
        //发起请求
        $result = $this->httpRequest('/trade/queryRefund.action', $params);
        //验证返回结果
        if ((int)$result['ra_Code'] !== 100) {
            //响应结果
            return $this->response(CodeLibrary::WITH_DO_NOT_ALLOW_STATE, $result['rb_CodeMsg'], $result);
        }
        //返回成功
        return $this->response(CodeLibrary::CODE_SUCCESS, '操作成功', [
            'rawData' => $result,
            'result' => [
                'state' => (int)$result['ra_Status'] === 100,
                'amount' => (int)((float)$result['r3_RefundAmount'] * 100),
                'stream_no' => $result['r4_RefundTrxNo'],
            ]
        ]);
    }


}
