<?php
namespace App\Services\Api;

// ----------------------------------------------------------------------
// 短地址接口
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Helpers\CurlRequest;
use Log;

// 需要引入 云天河写的对应类

class ShortUrlApiService
{
    const SINA_SOURCE_ID = '3271760578'; // 新浪API对应令牌地址
    const TIMER          = 3; // 设置超时时间,单位,秒

    /**
     * @var 渠道名
     */
    const CHANNEL_SINA  = 'sina';
    const CHANNEL_THIRD = 'third';
    const CHANNEL_BITLY = 'bitly';

    /**
     * @var 渠道API
     */
    const API_THIRD = 'http://qvni.cn/t.cn/ajax.php';
    const API_SINA  = 'http://api.t.sina.com.cn/short_url/shorten.json';
    const API_BITLY = 'https://bitly.com/data/shorten';

    /**
     * @var 渠道API关系
     */
    static $channel_list = [
        self::CHANNEL_THIRD => self::API_THIRD,
        // self::CHANNEL_SINA  => self::API_SINA, // 暂时用第三方替代
        self::CHANNEL_BITLY => self::API_BITLY,
    ];

    /**
     * 程序入口
     * @param string $long_url 长地址
     * @return array
     * [
     *     "url_short" => "",
     * ];
     */
    public static function run($long_url, $channel = self::CHANNEL_BITLY)
    {
        if (!array_key_exists($channel, self::$channel_list)) {
            throw new \Exception("未知渠道类型");
        }
        $channel_method = 'channel_' . $channel;
        CurlRequest::set_timeout_second(self::TIMER);

        $result    = self::$channel_method($long_url);
        $content   = $result['content'];
        $short_url = $result['short_url'];

        if (empty($short_url)) {
            Log::error(__CLASS__ . '---', compact('channel', 'content'));
            throw new \ApiException('获取短地址失败');
        } else {
            return $short_url;
        }
    }

    /**
     * 直连新浪---因 source_id 失效, 目前暂停使用
     *
     * @param string $long_url 长地址
     * @return array
     */
    private static function channel_sina($long_url)
    {
        $param             = [];
        $param['source']   = self::SINA_SOURCE_ID;
        $param['url_long'] = $long_url;
        $api               = self::API_SINA . '?' . http_build_query($param);
        // 发出请求
        $content   = CurlRequest::run($api);
        $info      = json_decode($content, true);
        $url_info  = $info[0] ?? null;
        $url_short = $url_info['url_short'] ?? '';
        return compact('content', 'url_short');
    }

    /**
     * 生成新浪短地址的第三方渠道 http://qvni.cn/t.cn/
     *
     * @param string $long_url 长地址
     * @return array
     */
    private static function channel_third($long_url)
    {
        $header = [
            "Accept: */*",
            "Accept-Encoding: gzip, deflate",
            "Accept-Language: zh-CN,zh;q=0.9,en;q=0.8",
            "Connection: keep-alive",
            "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
            "Host: qvni.cn",
            "Origin: http://qvni.cn",
            "Referer: http://qvni.cn/t.cn/",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36",
            "X-Requested-With: XMLHttpRequest",
        ];
        $param            = [];
        $param['longurl'] = $long_url;

        $api = self::API_THIRD;
        // 发出请求
        $content   = CurlRequest::run($api, http_build_query($param));
        $short_url = $content;
        return compact('content', 'short_url');
    }

    /**
     * 国外短地址 bitly.com
     *
     * @param string $long_url 长地址
     * @return array
     */
    private static function channel_bitly($long_url)
    {
        $header = [
            "Accept: application/json, text/javascript, */*; q=0.01",
            "Accept-Encoding: gzip, deflate",
            "Connection: keep-alive",
            "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
            "Host: bitly.com",
            "Referer: https://bitly.com",
            "Origin: https://bitly.com/",
            "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.37 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.37",
            "Cookie: _xsrf=c25d4fc8d9cf4efba60514ec1d3e2b52; anon_u=cHN1X18xY2M0YjM5My00NjljLTQ1MGQtOTY3YS1lYTE1YjgyNjBiYTc=|1570522320|aba80a2e5571ec4e6907917e10dd2c335f38fc6b; _mkto_trk=id:754-KBJ-733&token:_mch-bitly.com-1570522318465-19754; _ga=GA1.2.1372032362.1570522320; _gid=GA1.2.320332380.1570522320; _gat=1",
            "x-xsrftoken: c25d4fc8d9cf4efba60514ec1d3e2b52",
            "x-requested-with: XMLHttpRequest",
        ];
        $param        = [];
        $param['url'] = $long_url;
        $api          = self::API_BITLY;
        // 发出请求
        $content   = CurlRequest::run($api, http_build_query($param), $header);

        $response = json_decode($content, true);
        $short_url = $response['data']['anon_shorten']['aggregate_link'] ?? '';
        return compact('content', 'short_url');
    }

}
