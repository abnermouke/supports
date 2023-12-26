<?php

namespace Abnermouke\Supports\Providers\ThirdPayments\JoinPay\Prepay;

use Abnermouke\Supports\Library\CodeLibrary;
use Abnermouke\Supports\Providers\ThirdPayments\JoinPay\BasicProvider;

/**
 * 支付宝支付服务提供者
 */
class AlipayProvider extends BasicProvider
{

    //预下单信息
    protected $prepayData;

    /**
     * 构造函数
     * @param array $configs
     * @param array $prepayData
     */
    public function __construct(array $configs, array $prepayData = [])
    {
        //设置预下单信息
        $this->prepayData = $prepayData;
        //追加标识
        $configs['__CURRENT_ACTION__'] = '汇聚-支付宝支付';
        //引入父级构造
        parent::__construct($configs);
    }

    /**
     *
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 16:39:14
     * @param int $transaction_model H5模式；1:返回HTML，2：返回跳转链接
     * @param string $disable_pay_model
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function h5(int $transaction_model = 2, string $disable_pay_model = ''): object
    {
        //生成参数
        $params = array_merge($this->prepayData, [
            'qk_DisablePayModel' => $disable_pay_model,
            'q9_TransactionModel' => $transaction_model,
            'q1_FrpCode' => 'ALIPAY_H5'
        ]);
        //发起支付请求
        return $this->aliPay($params);
    }

    /**
     * 支付宝支付调用
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 16:39:39
     * @param array $params
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function aliPay(array $params): object
    {
        //生成签名
        $params['hmac'] = $this->getHmcMd5Signature($params);
        //发起请求
        $result = $this->httpRequest('/trade/uniPayApi.action', $params);
        //验证返回结果
        if ((int)$result['ra_Code'] !== 100) {
            //响应结果
            return $this->response(CodeLibrary::WITH_DO_NOT_ALLOW_STATE, $result['rb_CodeMsg'], $result);
        }
        //返回成功
        return $this->response(CodeLibrary::CODE_SUCCESS, '操作成功', [
            'rawData' => $result,
            'result' => $result['rc_Result'],
            'stream_no' => $result['r7_TrxNo']
        ]);
    }
}
