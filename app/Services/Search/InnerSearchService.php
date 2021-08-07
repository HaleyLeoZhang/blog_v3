<?php

namespace App\Services\Search;

// ----------------------------------------------------------------------
// 内网搜素服务
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Helpers\CurlRequest;
use LogService;

// 需要引入 云天河写的对应类

class InnerSearchService
{
    const TIMER = 2;

    /**
     * 程序入口
     * @param string $no 快递单号
     * @return
     */
    public static function run($keyword, $page = 1, $page_size = 10)
    {
        $return = [
            'total' => 0,
            'article_ids' => 0,
        ];

        CurlRequest::set_timeout_second(self::TIMER);
        $data = [
            "title" => $keyword,
            "describe" => $keyword,
            "category" => $keyword,
            'page' => $page,
            'page_size' => $page_size,
        ];
        $url = sprintf("%s/%s?%s", config('search.gateway_url'), "blog/front", http_build_query($data));
        // 请求接口
        $result = CurlRequest::run($url);
        // 调试接口
        $res = json_decode($result, true);
        $code = $res['code'] ?? 0;
        if ($code == 200) {
            $return['article_ids'] = $res['data']['ids'] ?? [];
            $return['total'] = $res['data']['total'] ?? 0;
        }
        return $return;
    }

}
