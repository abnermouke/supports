<?php

namespace Abnermouke\Supports\Providers\Sandpay\Hmf;

use Abnermouke\Supports\Assists\Arr;
use Abnermouke\Supports\Library\HelperLibrary;

/**
 * 杉德支付 - 河马付 - H5包装接入 （https://www.yuque.com/sd_cw/etmgxs/cq9zg4?）
 */
class H5PackProvider
{
    /**
     * 统一下单参数
     * @var array
     */
    private $params = [
        'version' => '10',
        'mer_no' => '',
        'store_id' => '100001',
        'clear_cycle' => '0',
        'gh_static_url' => '',
        'accsplit_info' => 'N',
        'jump_scheme' => 'hemacash://hmpay',
        'sign_type' => 'RSA',
        'meta_option' => '[{"s":"Android","n":"","id":"","sc":""},{"s":"IOS","n":"","id":"","sc":""}]',
        'pay_extra' => '{}'
    ];

    //支付参数
    private $order_data;

    //包装链接
    private $pack_urls = ['prefix' => '', 'suffix' => ''];

    //包装链接结果
    private $packed_link;

    //urlEncode参数
    private $encoding_keys = ['goods_name', 'notify_url', 'return_url', 'pay_extra', 'meta_option', 'sign'];

    //商户私钥地址
    private $private_key_path;

    /**
     * 构造函数
     * @param $params
     * @param $order_data
     */
    public function __construct($params, $order_data)
    {
        //设置支付参数
        $this->order_data = $order_data;
        //设置参数
        $this->params = array_merge($this->params, [
            'mer_order_no' => $this->order_data['out_trade_no'],
            'create_time' => HelperLibrary::formatDateTime(time(), 'YmdHis'),
            'expire_time' => HelperLibrary::formatDateTime(time()+7200, 'YmdHis'),
            'order_amt' => (string)$this->order_data['total_amount'],
            'goods_name' => $this->order_data['subject'],
            'create_ip' => str_replace('.', '_', $this->order_data['ip']),
        ], $params);
    }

    /**
     * 微信公众号包装链接
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 09:23:10
     * @param $private_key_path string 商户私钥绝对路径（生成1024位密钥对，公钥需上传并同步至杉德商户后台）
     * @param $mer_app_id string 公众号APPID
     * @param $mp_wechat_open_id string 该用户在公众号下的openid
     * @param $notify_url string 回调地址
     * @param $return_url string 返回地址
     * @param $cus_params array 自定义统一下单参数（详见：https://www.yuque.com/sd_cw/etmgxs/cq9zg4?#ddl85）
     * @return mixed
     */
    public function wechat_office_account($private_key_path, $mer_app_id, $mp_wechat_open_id, $notify_url, $return_url = '', $cus_params = [])
    {
        //设置商户私钥地址
        $this->private_key_path = $private_key_path;
        //初始化包装链接信息
        $this->pack_urls = ['prefix' => 'https://cash.sandgate.cn/h5/?', 'suffix' => '#/hippoPublic'];
        //更新下单参数
        $this->params = array_merge($this->params, [
            'product_code' => '01010002',
            'pay_extra' => '{"mer_app_id": "'.$mer_app_id.'","openid":"'.$mp_wechat_open_id.'"}',
            'notify_url' => $notify_url,
            'return_url' => $return_url
        ]);
        //判断是否存在自定义参数
        if ($cus_params) {
            //更新下单参数
            $this->params = array_merge($this->params, $cus_params);
        }
        //执行包装前置
        $this->beforePack();
        //执行包装后置
        $this->afterPack();
        //返回包装链接
        return $this->packed_link;
    }

    /**
     * 微信小程序包装链接
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 09:31:55
     * @param $private_key_path string 商户私钥绝对路径（生成1024位密钥对，公钥需上传并同步至杉德商户后台）
     * @param $gh_static_url string 小程序云静态网站url.html (截取到html即可)
     * @param $wx_app_id string 微信小程序APPID（必须正式发布）
     * @param $gh_ori_id string 微信小程序原始ID
     * @param $notify_url string 回调地址
     * @param $return_url string 返回地址
     * @param $cus_params array 自定义统一下单参数（详见：https://www.yuque.com/sd_cw/etmgxs/cq9zg4?#ddl85）
     * @return mixed
     */
    public function wechat_mini_programing($private_key_path, $gh_static_url, $wx_app_id, $gh_ori_id, $notify_url, $return_url = '',  $cus_params = [])
    {
        //设置商户私钥地址
        $this->private_key_path = $private_key_path;
        //初始化包装链接信息
        $this->pack_urls = ['prefix' => 'https://cash.sandgate.cn/h5/?', 'suffix' => '#/applet'];
        //更新下单参数
        $this->params = array_merge($this->params, [
            'product_code' => '01010006',
            'gh_static_url' => $gh_static_url,
            'pay_extra' => '{"wx_app_id":"'.$wx_app_id.'", "gh_ori_id": "'.$gh_ori_id.'", "path_url":"pages/zf/index?", "miniProgramType":"0"}',
            'notify_url' => $notify_url,
            'return_url' => $return_url
        ]);
        //判断是否存在自定义参数
        if ($cus_params) {
            //更新下单参数
            $this->params = array_merge($this->params, $cus_params);
        }
        //执行包装前置
        $this->beforePack();
        //执行包装后置
        $this->afterPack();
        //返回包装链接
        return $this->packed_link;
    }

    /**
     * 支付宝包装链接
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 09:35:17
     * @param $private_key_path string 商户私钥绝对路径（生成1024位密钥对，公钥需上传并同步至杉德商户后台）
     * @param $notify_url string 回调地址
     * @param $return_url string 返回地址
     * @param $cus_params array 自定义统一下单参数（详见：https://www.yuque.com/sd_cw/etmgxs/cq9zg4?#ddl85）
     * @return mixed
     */
    public function alipay($private_key_path, $notify_url, $return_url = '',  $cus_params = [])
    {
        //设置商户私钥地址
        $this->private_key_path = $private_key_path;
        //初始化包装链接信息
        $this->pack_urls = ['prefix' => 'https://cash.sandgate.cn/h5/?', 'suffix' => '#/hippoh5'];
        //更新下单参数
        $this->params = array_merge($this->params, [
            'product_code' => '01010006',
            'pay_extra' => '{}',
            'notify_url' => $notify_url,
            'return_url' => $return_url
        ]);
        //判断是否存在自定义参数
        if ($cus_params) {
            //更新下单参数
            $this->params = array_merge($this->params, $cus_params);
        }
        //执行包装前置
        $this->beforePack();
        //执行包装后置
        $this->afterPack();
        //返回包装链接
        return $this->packed_link;
    }

    /**
     * 包装前置方法（签名）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 09:21:46
     * @return bool
     */
    private function beforePack()
    {
        //循环参数
        foreach ($this->params as $k => $v) {
            //初始化参数信息为字符串
            if (!($this->params[$k] = (string)$v)) {
                //移除参数（剔除空参数）
                unset($this->params[$k]);
            }
        }
        //移除非必要参数
        $data = Arr::only($this->params, ['version', 'mer_no', 'mer_order_no', 'create_time', 'order_amt', 'notify_url', 'return_url', 'create_ip', 'store_id', 'gh_static_url', 'accsplit_info', 'sign_type', 'pay_extra']);
        //升序排列
        ksort($data);
        //私钥加密
        $priKey = $this->formatRsaKey(file_get_contents($this->private_key_path));
        //转换为openssl密钥，必须是没有经过pkcs8转换的私钥
        $res = openssl_get_privatekey($priKey);
        //调用openssl内置签名方法，生成签名$sign
        openssl_sign($this->urlParams($data), $sign, $res);
        //释放资源
        openssl_free_key($res);
        //返回加密结果
        $this->params['sign'] = base64_encode($sign);
        //返回成功
        return true;
    }

    /**
     * 包装后置方法（拼接链接）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 09:22:00
     * @return bool
     */
    private function afterPack()
    {
        //循环参数
        foreach (Arr::only($this->params, $this->encoding_keys) as $k => $v) {
            //初始化参数信息
            $this->params[$k] = rawurlencode($v);
        }
        //拼接链接
        $this->packed_link = $this->pack_urls['prefix'].self::urlParams($this->params).$this->pack_urls['suffix'];
        //返回成功
        return true;
    }

    /**
     * 链接参数拼接
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 09:22:13
     * @param $array array 拼接数组
     * @return string
     */
    private static function urlParams($array)
    {
        //整理参数
        $params = [];
        //循环内容
        foreach ($array as $k => $val) {
            //设置信息
            $params[] = $k . '=' . str_replace(' ', '+', $val);
        }
        //组合参数
        return implode('&', $params);
    }

    /**
     * 生成密钥
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-20 09:22:36
     * @param $key string 密钥内容
     * @param $alias string 密钥标识
     * @return string
     */
    private function formatRsaKey($key, $alias = 'RSA PRIVATE')
    {
        //生成pem
        $pem = "-----BEGIN $alias KEY-----\n".$key."-----END $alias KEY-----";
        //返回pem
        return $pem;
    }

}
