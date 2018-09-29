<?php
namespace App\Repositories\Admin;

use App\Repositories\Admin\Logic\MenuAdminLogic;

// ----------------------------------------------------------------------
// 仓储 - 菜单
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class MenuRepository
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
