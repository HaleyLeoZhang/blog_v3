<?php
namespace App\Repositories\Admin;

use App\Repositories\Admin\Logic\UploadAdminLogic;

// ----------------------------------------------------------------------
// 仓储 - 上传操作
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class UploadRepository
{

    /**
     * 上传 markdown 图片
     * @param array $file_info 文件用到的基本信息
     * @return array
     */
    public static function markdown($file_info)
    {
        return UploadAdminLogic::markdown($file_info);
    }

    /**
     * 删除文章分类
     * @param array $file_info 文件用到的基本信息
     * @return void
     */
    public static function editor($file_info)
    {
        return UploadAdminLogic::editor($file_info);
    }

}
