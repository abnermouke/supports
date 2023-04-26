<?php

namespace Abnermouke\Supports\Providers;

use Abnermouke\Supports\Library\CodeLibrary;
use Abnermouke\Supports\Library\HelperLibrary;
use GuzzleHttp\Client;

/**
 * 金山词霸服务提供者
 */
class IcibaProvider
{

    //爬取种子链接
    private static $seed_link = 'https://sentence.iciba.com/index.php?c=dailysentence&m=getdetail&title={DATE}';

    /**
     * 爬取句子
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 00:14:59
     * @param $days int 查询天数
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function crawl($days = 10)
    {
        //整理句子
        $sentences = [];
        //循环日数
        for ($i = 0; $i < $days; $i++) {
            //爬取指定日期
            if ($res = static::crawlDailySentence(HelperLibrary::formatDatetime(strtotime('- '.$i.' days'), 'Y-m-d'))) {
                //设置句子
                $sentences[] = $res;
            }
        }
        //返回句子
        return $sentences;
    }

    /**
     * 爬取指定日期句子
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 00:10:18
     * @param $date string 日期
     * @return array|false
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function crawlDailySentence($date)
    {
        //尝试发起请求
        try {
            //发起请求
            $response = (new Client())->get(str_replace('{DATE}', $date, static::$seed_link), [
                'verify' => false,
            ]);
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
        if (($result = json_decode($response->getBody()->getContents(), true)) && data_get($result, 'errmsg', '') == 'success') {
            //返回结果数据
            return [
                'date' => $date,
                'sentence_cn' => data_get($result, 'note', ''),
                'sentence_en' => data_get($result, 'content', ''),
            ];
        }
        //返回失败
        return false;
    }

}
