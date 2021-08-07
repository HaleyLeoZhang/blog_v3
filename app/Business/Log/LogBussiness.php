<?php
namespace App\Bussiness\Log;

use App\Bussiness\Log\Logic\AdminLogLogic;
use App\Bussiness\Log\Logic\UserLogLogic;
use App\Bussiness\Log\Logic\VisitorLogLogic;

// ----------------------------------------------------------------------
// 仓储 - 日志
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class LogBussiness
{
    /**
     * 登录日志 - 普通用户
     * @param int $user_id 普通用户id
     * @return void
     */
    public static function user_login_log($user_id)
    {
        UserLogLogic::user_login_log($user_id);
    }

    /**
     * 登录日志 - 管理员
     * @param int $admin_id 管理员id
     * @return void
     */
    public static function admin_login_log($admin_id)
    {
        AdminLogLogic::admin_login_log($admin_id);
    }

    /**
     * 访客日志 - 队列处理
     * @param array $ip, $header, $url
     * @return void
     */
    public static function analysis_visitor_foot_mark($params)
    {
        VisitorLogLogic::analysis_visitor_foot_mark($params);
    }

    /**
     * 访客阅读记录
     */
    public static function visitor_read_log($params)
    {
        VisitorLogLogic::visitor_read_log($params);
    }

    /**
     * 访客足迹查看
     * @param array $params
     * @return Pagnate
     */
    public static function visitor_foot_analysis_log($params)
    {
        return VisitorLogLogic::visitor_foot_analysis_log($params);
    }
}
