<?php
namespace App\Repositories\Admin;

use App\Repositories\Admin\Logic\IndexAdminLogic;

// ----------------------------------------------------------------------
// 仓储 - 首页
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class IndexRepository
{

    /**
     *
     * @return array
     */
    public static function hall()
    {
        return IndexAdminLogic::hall();
    }

    /**
     *
     * @return array
     */
    public static function login_log($params)
    {
        list($tds, $render) = IndexAdminLogic::login_log_td($params);
        $data               = [];
        $data['tds']        = $tds;
        $data['ths']        = IndexAdminLogic::login_log_th($params);
        $data['render']     = $render;
        $data['params']     = $params;
        return $data;
    }

    /**
     *
     * @return array
     */
    public static function self_info($params)
    {
        $admin = \CommonService::$admin;
        list($account_info, $render) = IndexAdminLogic::self_info($admin);
        $data               = [];
        $data['tds']        = $tds;
        return $data;
    }

}
