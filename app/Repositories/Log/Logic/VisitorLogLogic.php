<?php
namespace App\Repositories\Log\Logic;

use App\Helpers\Location;
use App\Models\Logs\VisitorFooterMark;
use App\Models\Logs\VisitorLookLog;

class VisitorLogLogic
{

    /**
     * @return void
     */
    public static function analysis_visitor_foot_mark($params)
    {
        extract($params);

        // $ip, $header, $url

        $location_info = Location::get_location_info($ip);
        $locate        = [];
        $locate[]      = $location_info['country'];
        $locate[]      = $location_info['area'];
        $locate[]      = $location_info['region'];
        $locate[]      = $location_info['city'];
        $locate[]      = $location_info['county'];
        $locate[]      = $location_info['isp'];

        $location = implode(' ', $locate);
        $log      = compact('ip', 'location', 'url', 'header');
        VisitorFooterMark::create($log);
        // 数据入队

    }

    /**
     * @return void
     */
    public static function visitor_read_log($params)
    {
        extract($params);
        $log             = [];
        $log['location'] = $location;
        VisitorLookLog::create($log);
    }

}
