<?php
namespace App\Helpers;

use App\Helpers\CurlRequest;

// ----------------------------------------------------------------------
// 获取客户端ip、对应地理位置
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class Location
{
    const API_TAOBAO = 'http://ip.taobao.com/service/getIpInfo2.php';

    /**
     * 获取用户IP
     * @param  String : return_array 是否返回截取的ip
     * @return String|Array : 用户实际IP | [用户实际IP,截取前两段的IP]
     */
    public static function get_ip($return_array = false)
    {
        //如果客户端 没有通过代理服务器来访问
        if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["REMOTE_ADDR"])) {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        //如果客户端 通过代理服务器来访问
        elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        } else {
            $ip = "Unknown";
        }
        // \LogService::info('RAW_IP:' . $ip);
        // X-Forwarded-For是用于记录代理信息的，
        // --- 每经过一级代理(匿名代理除外)，代理服务器都会把这次请求的来源IP追加在X-Forwarded-For中
        // --- ---（示例：IP:"124.65.115.234, 192.168.10.107"）的情况：
        $ip_arr            = explode(',', $ip);
        $ip_arr_last_index = count($ip_arr) - 1;
        if ($ip_arr_last_index) {
            $ip = trim($ip_arr[0]); // 开头的IP，为最初传过来的ip
        }
        // 选择返回的数据格式
        if (!$return_array) {
            return $ip;
        } else {
            $sub_ip = explode(".", $ip, 3); // 以 . 为界限差分为3个字符串
            array_pop($sub_ip); //去掉最后一个字符串
            $sub_ip = implode(".", $sub_ip);
            return [
                "real_ip" => $ip,
                "sub_ip"  => $sub_ip,
            ];
        }
    }

    /**
     * 获取IP对应的地理位置
     * @param string ip  ipv4地址
     * @return array
     */
    public static function get_location_info($ip)
    {
        CurlRequest::set_timeout_second(3);
        $params       = [];
        $params['ip'] = $ip;

        $request_url = self::API_TAOBAO . '?' . http_build_query($params);

        $content      = CurlRequest::run($request_url);
        $location_obj = json_decode($content, true);

        $default = [
            'country'    => '-',
            'area'       => '-',
            'region'     => '-',
            'city'       => '-',
            'county'     => '-',
            'isp'        => '-',
            'country_id' => '0',
            'area_id'    => '0',
            'region_id'  => '0',
            'county_id'  => '0',
            'isp_id'     => '0',
        ];
        $location_info = $location_obj['data'] ?? $default;

        $return['country']    = $location_info['country'];
        $return['area']       = $location_info['area'];
        $return['region']     = $location_info['region'];
        $return['city']       = $location_info['city'];
        $return['county']     = $location_info['county'];
        $return['isp']        = $location_info['isp'];
        $return['country_id'] = $location_info['country_id'];
        $return['isp_id']     = $location_info['isp_id'];
        $return['area_id']    = $location_info['area_id'];
        $return['region_id']  = $location_info['region_id'];
        $return['county_id']  = $location_info['county_id'];
        $return['isp_id']     = $location_info['isp_id'];

        return $return;
    }

}
