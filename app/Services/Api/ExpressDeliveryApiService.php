<?php
namespace App\Services\Api;

// ----------------------------------------------------------------------
// 快递查询
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Helpers\CurlRequest;
use Log;

// 需要引入 云天河写的对应类

class ExpressDeliveryApiService
{
    /**
     * @param String : API_LINK        快递所属物流公司
     * @param String : api_detail      快递具体信息
     * @param Int    : timer           设置超时时间，单位，秒
     */
    const API_LINK   = 'http://www.kuaidi100.com/autonumber/autoComNum?text=';
    const API_DETAIL = 'http://www.kuaidi100.com/query?';
    const TIMER      = 3;

    /**
     * 程序入口
     * @param string $tracking_number  快递单号
     * @return array
     */
    public static function run($tracking_number)
    {
        CurlRequest::set_timeout_second(self::TIMER);
        $api = self::API_DETAIL . self::get_status($tracking_number); // 拼接第一个接口
        // 发出请求
        $detail  = CurlRequest::run($api);
        $detail  = json_decode($detail, true);
        $message = $detail['message'] ?? 'failed';

        if ($message == 'ok') {
            Log::debug('ExpressDeliveryApi.', $detail['data']);
            return $detail['data'];
        } else {
            throw new \ApiException($message);
        }
    }

    /**
     * 查看单号所属公司，拼接为 GET 参数
     * @return String
     */
    private static function get_status($tracking_number)
    {
        // 参数过滤
        $api = self::API_LINK . $tracking_number; // 组装链接
        // 请求接口
        $result = CurlRequest::run($api);
        // 调试接口
        Log::debug('get_status'. $result);
        $info = json_decode($result, true);
        if (count($info['auto'])) {
            return http_build_query([
                'type'   => $info['auto'][0]['comCode'], // 快递名
                'postid' => $info['num'], // 快递单号
                'r'      => microtime(true), // 防缓存参数
            ]);
        } else {
            throw new \ApiException('暂无查询记录，请稍候再试');
        }
    }

}

/* 成功时，输出如下

[
{
"time": "2017-03-02 02:21:16",
"ftime": "2017-03-02 02:21:16",
"context": "\u6c5f\u95e8\u8f6c\u8fd0\u4e2d\u5fc3 \u5df2\u53d1\u51fa,\u4e0b\u4e00\u7ad9 \u6d4e\u5357\u8f6c\u8fd0\u4e2d\u5fc3",
"location": null
}, {
"time": "2017-03-02 01:41:59",
"ftime": "2017-03-02 01:41:59",
"context": "\u6c5f\u95e8\u8f6c\u8fd0\u4e2d\u5fc3 \u5df2\u6536\u5165",
"location": null
}
]

 */
