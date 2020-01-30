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
    const TIMER = 3; // 设置超时时间,单位,秒

    /**
     * @var 渠道名
     */
    const CHANNEL_SINA    = 'sina';
    const CHANNEL_BITLY   = 'bitly';
    const CHANNEL_TENCENT = 'tencent';

    /**
     * @var 渠道API
     */
    const API_SINA    = 'https://i.alapi.cn/url';
    const API_BITLY   = 'https://bitly.com/data/shorten';
    const API_TENCENT = 'http://sa.sogou.com/gettiny';

    /**
     * @var 渠道API关系
     */
    static $channel_list = [
        // self::CHANNEL_SINA    => self::API_SINA,
        self::CHANNEL_BITLY   => self::API_BITLY,
        // self::CHANNEL_TENCENT => self::API_TENCENT,
    ];

    /**
     * 程序入口
     * @param string $long_url 长地址
     * @return array
     * [
     *     "url_short" => "",
     * ];
     */
    public static function run($long_url, $channel = self::API_TENCENT)
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
     * 新浪短地址 t.cn
     * - 原理: 微博分享页拿到短地址
     *
     * @param string $long_url 长地址
     * @return array
     */
    private static function channel_sina($long_url)
    {
        $param        = [];
        $param['url'] = $long_url;

        $api = self::API_SINA . '?' . http_build_query($param);
        // 发出请求
        CurlRequest::set_follow(CurlRequest::IS_FOLLOW_YES);
        $content   = CurlRequest::run($api);
        $res = json_decode($content, true);
        $short_url = $res['shortUrl'] ?? '';
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
        $content = CurlRequest::run($api, http_build_query($param), $header);

        $response  = json_decode($content, true);
        $short_url = $response['data']['anon_shorten']['aggregate_link'] ?? '';

        $short_url = str_replace('bit.ly', 'j.mp', $short_url);
        return compact('content', 'short_url');
    }

    /**
     * 腾讯的 URl.CN
     *
     * @param string $long_url 长地址
     * @return array
     */
    private static function channel_tencent($long_url)
    {
        $param        = [];
        $param['url'] = $long_url;
        $api          = self::API_TENCENT . '?' . http_build_query($param);
        // 发出请求
        $content   = CurlRequest::run($api);
        $short_url = $content;
        return compact('content', 'short_url');
    }

}
