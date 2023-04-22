<?php

namespace Abnermouke\Supports\Library;

use Abnermouke\Supports\Assists\Arr;
use Abnermouke\Supports\Assists\File;
use Abnermouke\Supports\Assists\Path;
use Abnermouke\Supports\Assists\Str;

/**
 * 通用辅助方法藏类
 */
class HelperLibrary
{

    /**
     * 过滤字符表情（入DB库前处理）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 22:55:02
     * @param string $string 过滤文本
     * @return mixed
     */
    public static function filterEmoji($string)
    {
        //整理匹配规则
        $regex = '/(\\\u[ed][0-9a-f]{3})/i';
        //过滤信息
        return json_decode(preg_replace($regex, '', json_encode($string)), true);
    }

    /**
     * 二维数组根据字段进行排序
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 22:56:44
     * @param array $array 二维数组信息
     * @param string $field 排序字段
     * @param string $sort 排序规则
     * @return array
     */
    public static function arraySequence($array, $field, $sort = 'SORT_ASC')
    {
        //整理排序数组
        $arrSort = array();
        //循环数据
        foreach ($array as $uniq_id => $row) {
            //循环集合
            foreach ($row as $key => $value) {
                //设置内容
                $arrSort[$key][$uniq_id] = $value;
            }
        }
        //根据指定字段排序
        array_multisort($arrSort[$field], constant($sort), $array);
        //返回结果
        return $array;
    }

    /**
     * 转换时间信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 22:58:41
     * @param $time string 时间信息
     * @param $default mixed 默认时间戳
     * @return int|mixed
     */
    public static function getTimestamp($time, $default = false) {
        //判断时间信息
        if (!is_numeric($time) && !empty($time)) {
            //初始化信息
            $time = strtotime($time);
        }
        //初始化时间信息
        return (int)$time <= 0 ? ($default ? $default : time()) : (int)$time;
    }

    /**
     * 友好的时间提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:29:17
     * @param $time string 提示时间
     * @param $units array ['n' => '刚刚 , 's' => '秒', 'm' => '分', 'h' => '小时', 'd' => '天', 'w' => '周', 'mon' => '月']
     * @return array|false|int|mixed|string
     */
    public static function friendlyTime($time, $units = [])
    {
        //转换时间信息
        if (!($time = static::getTimestamp($time))) {
            //返回默认时间
            return $time;
        }
        //获取当前时间
        $cTime = time();
        //获取已过时间
        $dTime = $cTime - $time;
        //获取已过天数
        $dDay = (int)$dTime/3600/24;
        //初始化时间
        $timeString = date('Y.m.d H:i:s', $time);
        //判断时间
        if ((int)$dTime < 60) {
            //判断时间小于10秒
            if ($dTime < 10) {
                //设置时间字符串
                $timeString = data_get($units, 'n', '刚刚');
            } else {
                //设置时间字符串
                $timeString = $dTime . data_get($units, 's', ' 秒前');
            }
        } elseif ((int)$dTime < 3600) {
            //设置时间字符串
            $timeString = (int)($dTime / 60).data_get($units, 'm', '分钟前');
        } elseif ((int)$dDay === 0) {
            //设置时间字符串
            $timeString = (int)($dTime/3600).data_get($units, 'h', '小时前');
        } elseif ((int)$dDay > 0 && (int)$dDay <= 7) {
            //设置时间字符串
            $timeString = (int)$dDay.data_get($units, 'd', '天前');
        } elseif ((int)$dDay > 7 && (int)$dDay <= 30) {
            //设置时间字符串
            $timeString = (int)($dDay/7).data_get($units, 'w', '周前');
        } elseif ((int)$dDay > 30) {
            //设置时间字符串
            $timeString = (int)($dDay/30).data_get($units, 'mon', '月前');
        }
        //返回时间字符串
        return $timeString;
    }

    /**
     * 友好的数字提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:31:56
     * @param $number int 数字
     * @param $units array ['w' => 'w+', 'k' => 'k+']
     * @return mixed|string
     */
    public static function friendlyNumber($number, $units = [])
    {
        //判断长度
        if ((int)$number >= 10000) {
            //获取倍数
            $number = round($number / 10000 * 100) / 100 . data_get($units, 'w', 'w+');
        } elseif ($number >= 1000) {
            //获取倍数
            $number = round($number / 1000 * 100) / 100 . data_get($units, 'k', 'k+');
        }
        //返回数值
        return $number;
    }

    /**
     * 友好的重量提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:34:54
     * @param $heft int 重量
     * @param $units array ['d' => '吨', 'j' => '斤']
     * @return string
     */
    public static function friendlyHeft($heft = 0, $units = []) {
        //判断是否大于吨
        if ($heft >= 2000) {
            //返回信息
            return number_format($heft/2000, 2).data_get($units, 'd', '吨');
        }
        //返回重量
        return $heft.data_get($units, 'j', '斤');
    }

    /**
     * 友好的金额提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:35:42
     * @param $amount float 金额
     * @return string
     */
    public static function friendlyAmount($amount = 0)
    {
        //设置千
        $thousand = 1000;
        //设置万
        $million = 10000;
        //判断金额是否大于千
        if ($amount > $thousand) {
            //判断小于万
            if ($amount < $million) {
                //返回金额
                return sprintf("%.1f", (floor(($amount/$thousand) * 10)/10)).' 千';
            } else {
                //返回金额
                return sprintf('%.1f', (floor(($amount/$million)*10)/10)).' 万';
            }
        }
        //返回金额
        return number_format($amount, 2).' 元';
    }

    /**
     * 友好的文件大小提示
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:37:02
     * @param $file_size float 文件大小
     * @return string
     */
    public static function friendlyFileSize($file_size = 0) {
        //整理小数点位数
        $decimal_step = 0;
        //整理单位描述
        $format = 'bytes';
        //判断文件大小信息(KB级)
        if ((int)$file_size >= 1024 && (int)$file_size < pow(1024, 2)) {
            //重新整理信息
            $decimal_step = 1;
            $format = 'KB';
            $file_size /= pow(1024, (int)$decimal_step);
        }
        //判断文件大小信息(MB级)
        if ((int)$file_size >= pow(1024, 2) && (int)$file_size < pow(1024, 3)) {
            //重新整理信息
            $decimal_step = 2;
            $format = 'MB';
            $file_size /= pow(1024, (int)$decimal_step);
        }
        //判断文件大小信息(GB级)
        if ((int)$file_size >= pow(1024, 3) && (int)$file_size < pow(1024, pow(1024, 4))) {
            //重新整理信息
            $decimal_step = 3;
            $format = 'GB';
            $file_size /= pow(1024, (int)$decimal_step);
        }
        //判断文件大小信息(TB级)
        if ((int)$file_size >= pow(1024, 4) && (int)$file_size < pow(1024, 5)) {
            //重新整理信息
            $decimal_step = 3;
            $format = 'TB';
            $file_size /= pow(1024, (int)$decimal_step);
        }
        //返回大小信息
        return number_format($file_size, (int)$decimal_step).' '.$format;
    }

    /**
     * 获取指定格式时间
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:40:56
     * @param $time mixed 日期｜时间
     * @param $format string 指定格式
     * @return false|string
     */
    public static function formatDateTime($time = false, $format = 'Y-m-d H:i:s') {
        //返回指定格式时间
        return date($format, static::getTimestamp($time));
    }

    /**
     * 色值转RGB
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:42:04
     * @param $hexColor string  色值
     * @return array
     */
    public static function hexToRgb($hexColor)
    {
        $color = str_replace('#','',$hexColor);
        if (strlen($color)> 3){
            $rgb=array(
                'r'=>hexdec(substr($color,0,2)),
                'g'=>hexdec(substr($color,2,2)),
                'b'=>hexdec(substr($color,4,2))
            );
        }else{
            $rgb=array(
                'r'=>hexdec(substr($color,0,1). substr($color,0,1)),
                'g'=>hexdec(substr($color,1,1). substr($color,1,1)),
                'b'=>hexdec(substr($color,2,1). substr($color,2,1))
            );
        }
        return $rgb;
    }

    /**
     * 获取指定长度数字
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:43:39
     * @param $length int 长度
     * @return false|string
     */
    public static function getNumber($length = 6)
    {
        //生成数字
        $str = '1234567890';
        //判断数字长度
        $len = (int)(ceil($length/strlen($str)));
        //整理数字长度
        $str = (int)($len) > 0 ? str_repeat($str, ((int)$len + 1)) : $str;
        //截取长度
        $number = substr(str_shuffle($str), 0, (int)($length));
        //判断第一位是否为0
        return (int)($number[0]) === 0 ? static::getNumber($length) : $number;
    }

    /**
     * 对象转数组
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:45:03
     * @param $object mixed 对象内容
     * @return array|mixed
     */
    public static function objectToArray($object)
    {
        return $object && $object !== '[]' ? (is_array($object) ? $object : json_decode($object, true)) : [];
    }

    /**
     * 创建唯一编号（常用于订单号生成）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:45:56
     * @return string
     */
    public static function createSn() {
        //整理开头信息
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        //整理订单编号
        return $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(1000, 9999)).strtoupper(Str::random(4));
    }

    /**
     * 随机昵称
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:46:48
     * @param $last_name
     * @param $first_name
     * @return string
     */
    public static function randomNickname($last_name = 'XX', $first_name = '')
    {
        //设置首名
        $first_names = ['快乐的', '冷静的', '醉熏的', '潇洒的', '糊涂的', '积极的', '冷酷的', '深情的', '粗暴的', '温柔的', '可爱的', '愉快的', '义气的', '认真的', '威武的', '帅气的', '传统的', '潇洒的', '漂亮的', '自然的', '专一的', '听话的', '昏睡的', '狂野的', '等待的', '搞怪的', '幽默的', '魁梧的', '活泼的', '开心的', '高兴的', '超帅的', '留胡子的', '坦率的', '直率的', '轻松的', '痴情的', '完美的', '精明的', '无聊的', '有魅力的', '丰富的', '繁荣的', '饱满的', '炙热的', '暴躁的', '碧蓝的', '俊逸的', '英勇的', '健忘的', '故意的', '无心的', '土豪的', '朴实的', '兴奋的', '幸福的', '淡定的', '不安的', '阔达的', '孤独的', '独特的', '疯狂的', '时尚的', '落后的', '风趣的', '忧伤的', '大胆的', '爱笑的', '矮小的', '健康的', '合适的', '玩命的', '沉默的', '斯文的', '香蕉','苹果','鲤鱼','鳗鱼','任性的', '细心的', '粗心的', '大意的', '甜甜的', '酷酷的', '健壮的', '英俊的', '霸气的', '阳光的', '默默的', '大力的', '孝顺的', '忧虑的', '着急的', '紧张的', '善良的', '凶狠的', '害怕的', '重要的', '危机的', '欢喜的', '欣慰的', '满意的', '跳跃的', '诚心的', '称心的', '如意的', '怡然的', '娇气的', '无奈的', '无语的', '激动的', '愤怒的', '美好的', '感动的', '激情的', '激昂的', '震动的', '虚拟的', '超级的', '寒冷的', '精明的', '明理的', '犹豫的', '忧郁的', '寂寞的', '奋斗的', '勤奋的', '现代的', '过时的', '稳重的', '热情的', '含蓄的', '开放的', '无辜的', '多情的', '纯真的', '拉长的', '热心的', '从容的', '体贴的', '风中的', '曾经的', '追寻的', '儒雅的', '优雅的', '开朗的', '外向的', '内向的', '清爽的', '文艺的', '长情的', '平常的', '单身的', '伶俐的', '高大的', '懦弱的', '柔弱的', '爱笑的', '乐观的', '耍酷的', '酷炫的', '神勇的', '年轻的', '唠叨的', '瘦瘦的', '无情的', '包容的', '顺心的', '畅快的', '舒适的', '靓丽的', '负责的', '背后的', '简单的', '谦让的', '彩色的', '缥缈的', '欢呼的', '生动的', '复杂的', '慈祥的', '仁爱的', '魔幻的', '虚幻的', '淡然的', '受伤的', '雪白的', '高高的', '糟糕的', '顺利的', '闪闪的', '羞涩的', '缓慢的', '迅速的', '优秀的', '聪明的', '含糊的', '俏皮的', '淡淡的', '坚强的', '平淡的', '欣喜的', '能干的', '灵巧的', '友好的', '机智的', '机灵的', '正直的', '谨慎的', '俭朴的', '殷勤的', '虚心的', '辛勤的', '自觉的', '无私的', '无限的', '踏实的', '老实的', '现实的', '可靠的', '务实的', '拼搏的', '个性的', '粗犷的', '活力的', '成就的', '勤劳的', '单纯的', '落寞的', '朴素的', '悲凉的', '忧心的', '洁净的', '清秀的', '自由的', '小巧的', '单薄的', '贪玩的', '刻苦的', '干净的', '壮观的', '和谐的', '文静的', '调皮的', '害羞的', '安详的', '自信的', '端庄的', '坚定的', '美满的', '舒心的', '温暖的', '专注的', '勤恳的', '美丽的', '腼腆的', '优美的', '甜美的', '甜蜜的', '整齐的', '动人的', '典雅的', '尊敬的', '舒服的', '妩媚的', '秀丽的', '喜悦的', '甜美的', '彪壮的', '强健的', '大方的', '俊秀的', '聪慧的', '迷人的', '陶醉的', '悦耳的', '动听的', '明亮的', '结实的', '魁梧的', '标致的', '清脆的', '敏感的', '光亮的', '大气的', '老迟到的', '知性的', '冷傲的', '呆萌的', '野性的', '隐形的', '笑点低的', '微笑的', '笨笨的', '难过的', '沉静的', '火星上的', '失眠的', '安静的', '纯情的', '要减肥的', '迷路的', '烂漫的', '哭泣的', '贤惠的', '苗条的', '温婉的', '发嗲的', '会撒娇的', '贪玩的', '执着的', '眯眯眼的', '花痴的', '想人陪的', '眼睛大的', '高贵的', '傲娇的', '心灵美的', '爱撒娇的', '细腻的', '天真的', '怕黑的', '感性的', '飘逸的', '怕孤独的', '忐忑的', '高挑的', '傻傻的', '冷艳的', '爱听歌的', '还单身的', '怕孤单的', '懵懂的'];
        //判断信息
        $first_name = !empty($first_name) ? $first_name :  Arr::random($first_names);
        //组合信息
        return $first_name.$last_name;
    }

    /**
     * 隐藏字符串信息
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-17 23:59:28
     * @param $string string 字符串
     * @param $replace string 替换文字
     * @return string
     * @throws \Exception
     */
    public static function hideString($string, $replace = '*')
    {
        //判断是否为邮箱
        if (ValidateLibrary::email($string)) {
            //拆分号码
            $email_array = explode("@", $string);
            //获取前缀
            $prefix = (strlen($email_array[0]) < 4) ? "" : substr($string, 0, 3);
            //初始化次数
            $count = 0;
            //正则匹配
            $number = preg_replace('/([\d\w+_-]{0,100})@/', (str_repeat($replace, 3).'@'), $string, -1, $count);
            //组合信息
            $rs = $prefix . $number;
        } elseif (ValidateLibrary::bankCard($string)) {
            //直接处理
            $rs = substr($string, 0, 4) . str_repeat($replace, strlen($string)-5) . substr($string, -4);
        } else {
            //直接处理
            $rs = substr($string, 0, 3) . str_repeat($replace, strlen($string)-4) . substr($string, -1);
        }
        //返回结果信息
        return $rs;
    }

    /**
     * 字符串提取纯文本
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:00:11
     * @param $string string 字符串
     * @param $num int 指定长度
     * @return array|mixed|string|string[]
     */
    public static function stringToText($string, $num = 0){
        //判断字符串
        if($string){
            //把一些预定义的 HTML 实体转换为字符
            $html_string = htmlspecialchars_decode($string);
            //将空格替换成空
            $content = str_replace(" ", "", $html_string);
            //函数剥去字符串中的 HTML、XML 以及 PHP 的标签,获取纯文本内容
            $contents = strip_tags($content);
            //返回字符串中的前$num字符串长度的字符
            return (int)$num > 0 ? (mb_strlen($contents,'utf-8') > $num ? mb_substr($contents, 0, $num, "utf-8").'....' : mb_substr($contents, 0, $num, "utf-8")) : $content;
        }else{
            return $string;
        }
    }

    /**
     * 获取链接参数
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:01:35
     * @param $url string 链接
     * @return array
     */
    public static function parseUrlParams($url)
    {
        //初始化链接信息
        $url_info = parse_url($url);
        //设置参数信息
        $params = [];
        //判读是否存在参数
        if ($url_info['query']) {
            //拆分信息
            foreach (explode('&', $url_info['query']) as $param) {
                //初始化信息
                $param = explode('=', $param);
                //初始化信息
                $params[$param[0]] = $param[1];
            }
        }
        //返回参数
        return $params;
    }

    /**
     * 查询是否存在与某个数组（一维数组）
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:01:55
     * @param $search string 查询内容
     * @param $arr array 查询数组
     * @return bool
     */
    public static function existArr($search, $arr)
    {
        //搜索值
        $res = array_search($search, $arr);
        //返回是否成立
        return is_numeric($res) && $res >= 0;
    }

    /**
     * 转换金额
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:03:09
     * @param $amount int 金额（建议金额单位为分）
     * @param $decimal int 保留几位小数
     * @param $ratio int 倍数
     * @return string
     */
    public static function convertAmount($amount, $decimal = 2, $ratio = 100)
    {
        return sprintf('%.'.(int)$decimal.'f', ($ratio > 0 ? (int)$amount/$ratio : $amount));
    }

    /**
     * 计算金额百分比
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 22:12:17
     * @param $amount int 金额（建议金额单位为分）
     * @param $percent float 指定百分比
     * @param $ratio int 倍数
     * @return int
     */
    public static function computePercentAmount($amount, $percent = 50, $ratio = 0)
    {
        return (int)(floor($amount * $percent / $ratio));
    }

    /**
     * XML转数组
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:04:07
     * @param $xml mixed XML实例
     * @return mixed
     */
    public static  function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring), true);
        return $val;
    }

    /**
     * 获取更短Md5随机唯一字符
     * @Author Abnermouke <abnermouke@outlook.com | yunnitec@outlook.com>
     * @Originate in YunniTec <https://www.yunnitec.com/>
     * @Time 2023-04-18 00:07:29
     * @param $md5_hash_str string MD5结果
     * @return array|string|string[]
     */
    public static function shortMd5($md5_hash_str)
    {
        //初始化解析字段
        $md5_bin_str = '';
        //拆分md5 hash结果
        foreach (str_split($md5_hash_str, 2) as $byte_str) {
            //追加解析字段
            $md5_bin_str .= chr(hexdec($byte_str));
        }
        //base64处理
        $md5_b64_str = base64_encode($md5_bin_str);
        //截取指定长度
        $md5_b64_str = substr($md5_b64_str, 0, 22);
        //替换无效字符并返回
        return str_replace(['+', '/'], ['-', '_'], $md5_b64_str);
    }


}
