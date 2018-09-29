<?php

namespace App\Traits;

use App\Helpers\Location;

trait LogLocationTrait
{
    /**
     * 用户详细地址
     * @return array 可以用 list() 方法 接收数据
     */
    public static function location_info()
    {
        $ip            = Location::get_ip();
        $location_info = Location::get_location_info($ip);

        $location   = [];
        $location[] = $location_info['country'];
        $location[] = $location_info['area'];
        $location[] = $location_info['region'];
        $location[] = $location_info['city'];
        $location[] = $location_info['county'];
        $location[] = $location_info['isp'];

        $str = implode(' ', $location);
        $str = trim($str);

        return [
            $ip,
            $str,
        ];
    }
}
