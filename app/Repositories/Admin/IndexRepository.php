<?php
namespace App\Repositories\Admin;

use App\Repositories\Admin\Logic\IndexAdminLogic;
use App\Repositories\Admin\Logic\CommonAdminLogic;

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
     * @return void
     */
    public static function user_password_edit($password_raw)
    {
        $password = CommonAdminLogic::decrypt($password_raw);
        IndexAdminLogic::user_password_edit($password);
    }

}
