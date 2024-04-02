<?php

namespace Abnermouke\Supports\Providers\ThirdPayments\JoinPay\Prepay;

use Abnermouke\Supports\Library\CodeLibrary;
use Abnermouke\Supports\Providers\ThirdPayments\JoinPay\BasicProvider;

/**
 * 微信支付服务提供者
 */
class WechatProvider extends BasicProvider
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
        $configs['__CURRENT_ACTION__'] = '汇聚-微信支付';
        //引入父级构造
        parent::__construct($configs);
    }

    /**
     * 微信APP支付
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 16:26:29
     * @param string $disable_pay_model
     * @param string $wx_app_id
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function app(string $disable_pay_model = '', string $wx_app_id = ''): object
    {
        //生成参数
        $params = array_merge($this->prepayData, [
            'qk_DisablePayModel' => $disable_pay_model,
            'q7_AppId' => $wx_app_id ?? $this->configs['weixin_app_id'],
            'q1_FrpCode' => 'WEIXIN_APP3'
        ]);
        //发起支付请求
        return $this->wechatPay($params);
    }

    /**
     * 微信公众号支付
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 16:34:58
     * @param string $open_id
     * @param string $disable_pay_model
     * @param string $wx_mp_app_id
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function mp(string $open_id, string $disable_pay_model = '', string $wx_mp_app_id = ''): object
    {
        //生成参数
        $params = array_merge($this->prepayData, [
            'qk_DisablePayModel' => $disable_pay_model,
            'q7_AppId' => $wx_mp_app_id ?? $this->configs['weixin_mp_app_id'],
            'q5_OpenId' => $open_id,
            'q1_FrpCode' => 'WEIXIN_GZH'
        ]);
        //发起支付请求
        return $this->wechatPay($params);
    }

    /**
     * 微信小程序支付
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 16:35:09
     * @param string $open_id
     * @param string $disable_pay_model
     * @param string $wx_mini_app_id
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function mini(string $open_id, string $disable_pay_model = '', string $wx_mini_app_id = ''): object
    {
        //生成参数
        $params = array_merge($this->prepayData, [
            'qk_DisablePayModel' => $disable_pay_model,
            'q7_AppId' => $wx_mini_app_id ?? $this->configs['weixin_mini_app_id'],
            'q5_OpenId' => $open_id,
            'q1_FrpCode' => 'WEIXIN_XCX'
        ]);
        //发起支付请求
        return $this->wechatPay($params);
    }

    /**
     * 微信H5支付
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 16:35:18
     * @param string $disable_pay_model
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function h5(string $disable_pay_model = ''): object
    {
        //生成参数
        $params = array_merge($this->prepayData, [
            'qk_DisablePayModel' => $disable_pay_model,
            'q1_FrpCode' => 'WEIXIN_H5_PLUS'
        ]);
        //发起支付请求
        return $this->wechatPay($params);
    }

    /**
     * 获取微信支付参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Company Chongqing Yunni Network Technology Co., Ltd.
     * @Time 2023-12-26 16:31:02
     * @param array $params
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function wechatPay(array $params): object
    {
        //生成签名
        $params['hmac'] = $this->getHmcMd5Signature($params);
        //发起请求
        $result = $this->httpRequest('/trade/uniPayApi.action', $params);
        //验证返回结果
        if (!$result || (int)$result['ra_Code'] !== 100) {
            //响应结果
            return $this->response(CodeLibrary::WITH_DO_NOT_ALLOW_STATE, data_get($result, 'rb_CodeMsg', 'UNKNOWN'), $result);
        }
        //返回成功
        return $this->response(CodeLibrary::CODE_SUCCESS, '操作成功', [
            'out_trade_no' => $result['r2_OrderNo'],
            'amount' => (int)((float)$result['r3_Amount'] * 100),
            'stream_no' => $result['r7_TrxNo'],
            'payData' => $result['rc_Result'],
            'rawData' => $result,
        ]);
    }


}
