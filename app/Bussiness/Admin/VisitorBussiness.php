<?php
namespace App\Bussiness\Admin;

use App\Bussiness\Admin\Logic\VisitorAdminLogic;
use App\Bussiness\Log\Logic\VisitorLogLogic;

// ----------------------------------------------------------------------
// 仓储 - 用户信息
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class VisitorBussiness
{

    /**
     * 访客足迹查看
     * @param array $params device_type、ip、time_start, time_end
     * @return array
     */
    public static function foot_mark_analysis($params)
    {
        return VisitorLogLogic::visitor_foot_analysis_log($params);
    }

}
