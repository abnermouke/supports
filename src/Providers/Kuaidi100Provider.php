<?php

namespace Abnermouke\Supports\Providers;

use Abnermouke\Supports\Library\FakeUserAgentLibrary;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * 快递100服务提供者
 */
class Kuaidi100Provider
{


    //种子链接
    private $seed_link = 'http://cloud.kuaidi100.com/api';

    //请求密钥等
    private $secret_key = '';
    private $secret_code = '';
    private $secret_sign = '';

    /**
     * 创建实例
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 00:18:51
     * @param $secret_key string 密钥KEY
     * @param $secret_code string 密钥CODE
     * @param $secret_sign string 密钥
     * @return Kuaidi100Provider
     */
    public static function make($secret_key, $secret_code, $secret_sign)
    {
        //创建实例
        return (new Kuaidi100Provider($secret_key, $secret_code, $secret_sign));
    }

    /**
     * 构造函数
     * @param $secret_key string 密钥KEY
     * @param $secret_code string 密钥CODE
     * @param $secret_sign string 密钥
     */
    public function __construct($secret_key, $secret_code, $secret_sign)
    {
        //设置请求密钥
        $this->secret_key = $secret_key;
        $this->secret_code = $secret_code;
        $this->secret_sign = $secret_sign;
    }

    /**
     * 请求物流跟踪信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 00:21:19
     * @param $alias string 快递公司编号
     * @param $number string 物流编号
     * @param $contact_mobile int 收货人电话（顺丰等快递需要）
     * @return array|false
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function query($alias, $number, $contact_mobile)
    {
        //判断数据
        if (!$this->secret_key || !$this->secret_code || !$this->secret_sign) {
            //返回失败
            return false;
        }
        //设置请求参数
        $params = json_encode(['com' => $alias, 'num' => $number, 'phone' => $contact_mobile]);
        //尝试查询
        try {
            //引入请求示例
            $client = new Client();
            //发起请求
            $response = $client->post($this->seed_link, [
                'form_params' => [
                    'secret_key' => $this->secret_key,
                    'secret_code' => $this->secret_code,
                    'secret_sign' => $this->secret_sign,
                    'param' => $params
                ],
                //取消https验证
                'verify' => false
            ]);

        } catch (\Exception $exception) {
            //返回失败
            return false;
        }
        //判断是否请求失败
        if ((int)$response->getStatusCode() !== 200) {
            //返回失败
            return false;
        }
        //获取返回结果
        $result = json_decode($response->getBody()->getContents(), true);
        //判断请求是否成功
        if ((int)$result['status'] !== 200) {
            //返回失败
            return false;
        }
        //返回成功
        return ['isCheck' => ((int)$result['ischeck'] === 1), 'data' => $result['data']];
    }

    /**
     * 查询常用物流公司（较长间隔查询，避免IP被封）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 00:29:19
     * @return array|false
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function expresses()
    {
        //实例化请求
        $client = new Client();
        //发起请求
        $response = $client->request('GET', 'https://www.kuaidi100.com/frame/index.html', [
            'headers' => [
                'User-Agent' => FakeUserAgentLibrary::random(),
                'Referer' => 'https://www.kuaidi100.com'
            ],
            'verify' => false
        ]);
        //判断状态
        if ((int)$response->getStatusCode() !== 200) {
            //返回失败
            return false;
        }
        //获取结果
        $content = $response->getBody()->getContents();
        //引入爬取工具
        $crawler = new Crawler();
        //设置内容
        $crawler->addHtmlContent($content);
        //获取结果结构
        $res = $crawler->filterXPath("//div[@id='companyList']//dd/a");
        //整理快递公司
        $expresses = [];
        //尝试处理
        try {
            //循环节点处理
            foreach ($res as $k => $node) {
                //实例化爬取工具
                $c = new Crawler($node);
                //添加内容
                $expresses[trim($c->attr('data-code'))] = ['guard_name' => trim($c->text()), 'alias' => trim($c->attr('data-code')), 'logo' => $this->getExpressLogo(trim($c->attr('href')))];
            }
        } catch (\InvalidArgumentException $exception) {
            //忽略错误
        }
        //返回物流公司
        return $expresses;
    }

    /**
     * 获取物流公司LOGO
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-19 00:28:02
     * @param $express_link string 物流公司详情页地址
     * @return false|string|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getExpressLogo($express_link)
    {
        //判断链接信息
        $express_link = !strstr($express_link, 'https://www.kuaidi100.com') ? 'https://www.kuaidi100.com'.$express_link : $express_link;
        //整理图片链接
        $image_link = '';
        //尝试获取信息
        try {
            //实例化请求
            $client = new Client();
            //发起请求
            $response = $client->request('GET', $express_link, [
                'headers' => [
                    'User-Agent' => FakeUserAgentLibrary::random(),
                    'Referer' => 'https://www.kuaidi100.com/frame/index.html'
                ],
                'verify' => false
            ]);
            //判断状态
            if ((int)$response->getStatusCode() !== 200) {
                //返回失败
                return false;
            }
            //获取结果
            $content = $response->getBody()->getContents();
            //引入爬取工具
            $crawler = new Crawler();
            //设置内容
            $crawler->addHtmlContent($content);
            //获取图片链接
            $image_link = $crawler->filterXPath('//a[@id="selectComBtn"]/img')->attr('src');
        } catch (\Exception | \InvalidArgumentException | ClientException $exception) {

        }
        //返回图片链接
        return $image_link;
    }

}
