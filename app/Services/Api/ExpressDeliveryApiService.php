<?php
namespace App\Services\Api;

// ----------------------------------------------------------------------
// 快递查询V2
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
     * @param Int    : TIMER           设置超时时间，单位，秒
     */
    const API_LINK   = 'https://www.kuaidi100.com/autonumber/autoComNum?resultv2=1&text=%s';
    const API_DETAIL = 'https://www.kuaidi100.com/query?type=%s&postid=%s&temp=%s&phone=%s';
    const TIMER      = 3;

    static $header = [
            'Accept: application/json, text/javascript, */*; q=0.01',
            'Accept-Encoding: gzip, deflate, br',
            'Accept-Language: zh-CN,zh;q=0.9,en;q=0.8',
            'Connection: keep-alive',
            'Host: www.kuaidi100.com',
            'Referer: https://www.kuaidi100.com/?from=openv',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Site: same-origin',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36',
            'X-Requested-With: XMLHttpRequest',
    ];

    /**
     * 程序入口
     * @param string $no 快递单号
     * @return array
     */
    public static function run($no)
    {
        CurlRequest::set_timeout_second(self::TIMER);

        $param = [
            self::get_company($no),
            $no,
            '0.'. mt_rand(1000000000000000, 9999999999999999), // 16位随机数
            '',
        ];

        $api = sprintf(self::API_DETAIL, ...$param); // 组装链接
        // 发出请求
        $detail  = CurlRequest::run($api, null, self::$header);
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
    private static function get_company($no)
    {
        // 参数过滤
        $api = sprintf(self::API_LINK, $no); // 组装链接
        // 请求接口
        $result = CurlRequest::run($api, null, self::$header);
        // 调试接口
        $info = json_decode($result, true);
        if (count($info['auto'])) {
            $com_code = $info['auto'][0]['comCode'] ?? '';
            return $com_code;
        } else {
            throw new \ApiException('暂无查询记录，请稍候再试');
        }
    }

}
