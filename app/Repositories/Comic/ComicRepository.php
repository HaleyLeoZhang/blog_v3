<?php
namespace App\Repositories\Comic;

use App\Models\Logs\ComicDownloadLogs;
use App\Repositories\Comic\Logic\CommonLogic;
use App\Repositories\Comic\Logic\OutputComicLogic;

// ----------------------------------------------------------------------
// 漫画爬取服务，资源源站 https://www.tohomh.com
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class ComicRepository
{

    /**
     * 漫画 - 一人之下
     * @return void
     */
    public static function yirenzhixia()
    {
        CommonLogic::run(ComicDownloadLogs::COMMIC_ID_YIRENZHIXIA);
    }

    /**
     * 漫画 - 最强农民工
     * @return void
     */
    public static function zuijiangnongmingong()
    {
        CommonLogic::run(ComicDownloadLogs::COMMIC_ID_ZUIJIANGNONGMINGONG);
    }

    // ------------------------------------------------------------

    /**
     * 漫画 API
     * @return array
     */
    public static function pic_list($params): array
    {
        $list = OutputComicLogic::pic_list($params);
        return $list;
    }

}
