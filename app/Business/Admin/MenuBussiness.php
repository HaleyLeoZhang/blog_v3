<?php
namespace App\Bussiness\Admin;

use App\Bussiness\Admin\Logic\MenuAdminLogic;

// ----------------------------------------------------------------------
// 仓储 - 菜单
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class MenuBussiness
{

    /**
     * 设置导航栏
     * @return string
     */
    public static function show_menu(): string
    {
        return MenuAdminLogic::show_menu();
    }

}
