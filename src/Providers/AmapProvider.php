<?php

namespace Abnermouke\Supports\Providers;

use Abnermouke\Supports\Library\CodeLibrary;
use Abnermouke\Supports\Assists\Arr;
use GuzzleHttp\Client;

/**
 * 高德地图服务提供者
 */
class AmapProvider
{
    /**
     * 获取IP所在省份 https://lbs.amap.com/api/webservice/guide/api/ipconfig
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:10:40
     * @param $ip string IP地址
     * @param $key string 高德地图密钥
     * @param $ip_type int ip类型
     * @param $default_province_codes array 默认省份编码
     * @return array|int|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function ipProvinceCode($ip, $key, $ip_type = 4, $default_province_codes = [110000, 120000, 310000, 500000])
    {
        //整理参数
        $params = [
            'key' => $key,
            'type' => (int)$ip_type,
            'ip' => $ip,
        ];
        //设置默认地区
        $default_province = Arr::random($default_provinces);
        //整理链接
        $seed_link = 'https://restapi.amap.com/v3/ip?'.http_build_query($params);
        //尝试发起请求
        try {
            //生成请求实例
            $client = new Client();
            //发起请求
            $response = $client->get($seed_link, ['verify' => false]);
        } catch (\Exception $exception) {
            //设置默认地区
            $default_province = Arr::random($default_provinces);
        }
        //判断请求方式
        if ((int)$response->getStatusCode() === CodeLibrary::CODE_SUCCESS) {
            //获取请求结果
            $result = $response->getBody()->getContents();
            //解析结果
            $result = object_2_array($result);
            //判断结果
            if ((int)data_get($result, 'status', 0) === 1) {
                //获取省份
                $province = data_get($result, 'adcode', []);
                //判断省份信息
                if ($province && !empty($province)) {
                    //设置默认地区code
                    $default_province = (int)$province;
                }
            }
        }
        //返回地区信息
        return $default_province;
    }

    /**
     * 获取高德行政地址结果 https://lbs.amap.com/api/webservice/guide/api/district
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 15:16:02
     * @param $key string 高德地图密钥
     * @param $ad_code int 上级地区编码
     * @return array|false|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function queryArea($key, $ad_code = 0)
    {
        //整理参数
        $params = [
            'keywords' => (int)$ad_code === 0 ? '' : (int)$ad_code,
            'key' => $key,
            'subdistrict' => 1,
        ];
        //整理请求链接
        $query_link = 'https://restapi.amap.com/v3/config/district'.(!empty($params) ? '?'.http_build_query($params) : '');
        //尝试发起请求
        try {
            //发起请求
            $response = (new Client())->get($query_link);
        } catch (\Exception $exception) {
            //返回失败
            return false;
        }
        //获取状态
        if ((int)$response->getStatusCode() !== CodeLibrary::CODE_SUCCESS) {
            //返回失败
            return false;
        }
        //获取结果集
        $results = $response->getBody()->getContents();
        //返回地区信息
        return data_get(json_decode($results, true), 'districts.0.districts', []);
    }


}
