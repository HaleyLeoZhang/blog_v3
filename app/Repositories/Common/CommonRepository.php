<?php
namespace App\Repositories\Common;

use App\Repositories\Common\Logic\CommonLogic;

// ----------------------------------------------------------------------
// 公共
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class CommonRepository
{
    /**
     * 背景音乐
     */
    public static function memorabilia_bg()
    {
        $url  = CommonLogic::memorabilia_bg();
        $data = compact('url');
        return $data;
    }

    /**
     * 快递查询
     * @param string tracking_number 快递单号
     * @return array
     */
    public static function express_delivery($tracking_number)
    {
        $track_info = CommonLogic::express_delivery($tracking_number);
        $data       = compact('track_info');
        return $data;
    }

    /**
     * 快递查询
     * @param string long_url 长地址
     * @return array
     */
    public static function short_url($long_url, $channel)
    {
        $short_url = CommonLogic::short_url($long_url, $channel);
        $data      = compact('short_url');
        return $data;
    }

}
