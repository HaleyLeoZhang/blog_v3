<?php
namespace App\Services\Api;

// ----------------------------------------------------------------------
// 新浪短地址接口
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Helpers\CurlRequest;
use Log;

// 需要引入 云天河写的对应类

class ShortUrlApiService
{
    /**
     * @param String : API_LINK   API请求地址
     * @param String : SOURCE_ID  资源ID
     * @param Int    : TIMER      设置超时时间，单位，秒
     */
    const API_LINK  = 'http://api.t.sina.com.cn/short_url/shorten.json';
    const SOURCE_ID = '3271760578';
    const TIMER     = 3;

    /**
     * 程序入口
     * @param string $tracking_number  快递单号
     * @return array
     */
    public static function run($long_url)
    {
        CurlRequest::set_timeout_second(self::TIMER);
        $param             = [];
        $param['source']   = self::SOURCE_ID;
        $param['url_long'] = $long_url;
        $api               = self::API_LINK . '?' . http_build_query($param);
        // 发出请求
        $content   = CurlRequest::run($api);
        $info      = json_decode($content,true);
        $url_info = $info[0] ?? null;
        $url_short = $url_info['url_short'];
        if (!empty($url_short)) {
            Log::debug(__CLASS__ . '---', [ $info ]);
            return $url_short;
        } else {
            throw new \ApiException('获取短地址失败');
        }
    }

}
