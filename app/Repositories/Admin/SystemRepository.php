<?php
namespace App\Repositories\Admin;

use App\Repositories\Admin\Logic\SystemModuleAdminLogic;

// ----------------------------------------------------------------------
// 仓储 - 系统配置
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class SystemRepository
{

    /**
     * 查看所有上传过的图片
     * @param array $params 
     * @return array
     */
    public static function pic_bed($params)
    {
        return SystemModuleAdminLogic::pic_bed($params);
    }

    /**
     * 修改或添加新的图片
     * @return void
     */
    public static function pic_bed_update($params)
    {
        SystemModuleAdminLogic::pic_bed_update($params);
    }

}
