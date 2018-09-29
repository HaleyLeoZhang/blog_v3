<?php
namespace App\Helpers;

// ----------------------------------------------------------------------
// cURL常用封装
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

// 使用案例，见文末

class CurlRequest
{

    // 配置项
    protected static $timeout = 0; // 设置默认超时秒数，0 => 不需要设置

    /**
     * POST或GET请求，并返回数据
     * @param  String      url     访问地址
     * @param  Array|JSON  data    用于POST的数据
     * @param  Array       header  HTTP头请求
     * @return String  返回数据
     */
    public static function run($url, $data = null, $header = null)
    {
        //请求 URL，返回该 URL 的内容
        $ch = curl_init(); // 初始化curl
        curl_setopt($ch, CURLOPT_URL, $url); // 设置访问的 URL
        curl_setopt($ch, CURLOPT_HEADER, 0); // 放弃 URL 的头信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 返回字符串，而不直接输出
        // Add Headers?
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        // Https ?
        if (preg_match('/^https/', $url)) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 不做服务器的验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 做服务器的证书验证
        }
        // POST method?
        if ($data) {
            curl_setopt($ch, CURLOPT_POST, true); // 设置为 POST 请求
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // 设置POST的请求数据
        }
        // Time out?
        if (self::$timeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeout);
        }
        // 模拟重定向
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // gzip 解压
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        $content = curl_exec($ch); // 开始访问指定URL
        curl_close($ch); // 关闭 cURL 释放资源
        return $content;
    }

    /**
     * 设置当前工具全局 Curl 请求最大时长
     * @param int $second 设置的curl请求，超时的秒数
     */
    public static function set_timeout_second($second)
    {
        self::$timeout = $second;
    }
}

// // 示例爬取 酷狗音乐，'刚好遇见你' 的链接地址

// // 对应音乐的fileHash

// $fileHash = '1BA52AFC430A1D0EBF9C7271BD71E6B9';
// $url      = 'http://www.kugou.com/yy/index.php?r=play/getdata&hash=' . $fileHash;
// $header   = [
//     "Accept:application/json, text/javascript",
//     "Connection:keep-alive",
//     "Host:www.kugou.com",
//     "Referer:http://www.kugou.com/song/",
//     "User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.221 Safari/537.36 SE 2.X MetaSr 1.0",
//     "X-Requested-With:XMLHttpRequest",
// ];
// $d          = CurlRequest::run($url, null, $header);
// $d          = json_decode($d, true);
// $msg['url'] = $d['data']['play_url'];
// exit(json_encode($msg));
