<?php
namespace App\Repositories\Admin;

use App\Repositories\Admin\Logic\CommonModuleAdminLogic;

// ----------------------------------------------------------------------
// 仓储 - 公共配置
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class CommonRepository
{

    /**
     * 查看所有友情链接
     * @return array
     */
    public static function friend_link()
    {
        return CommonModuleAdminLogic::friend_link();
    }

    /**
     * 修改或添加新的链接
     * @return void
     */
    public static function friend_link_update($params)
    {
        CommonModuleAdminLogic::friend_link_update($params);
    }

}
