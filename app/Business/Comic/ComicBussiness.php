<?php
namespace App\Bussiness\Comic;

use App\Models\Logs\ComicDownloadLogs;
use App\Bussiness\Comic\Logic\CommonLogic;
use App\Bussiness\Comic\Logic\OutputComicLogic;

// ----------------------------------------------------------------------
// 漫画爬取服务，资源源站 https://www.tohomh.com
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class ComicBussiness
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

    /**
     * 漫画 - 戒魔人
     * @return void
     */
    public static function jiemoren()
    {
        CommonLogic::run(ComicDownloadLogs::COMMIC_ID_JIEMOREN);
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
