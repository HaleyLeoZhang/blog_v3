<?php
namespace tests\Once;

use App\Models\Logs\VisitorFootMark;
use App\Bussiness\Log\Logic\VisitorLogLogic;
use LogService;

class FootMarkAnalysisExecuteTest extends \TestCase
{
    const CHUNK_LEN = 100;

    /**
     * 本地一次性执行，然后批量把数据导入到线上
     */
    public function ana_footer_data()
    {
        LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.start');
        VisitorFootMark::orderBy('id', 'desc')
            ->chunk(self::CHUNK_LEN, function ($models) {
                LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.info.开始一轮');
                foreach ($models as $foot_mark) {
                    VisitorLogLogic::visitor_foot_analysis($foot_mark);
                }
                LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.info.结束一轮');
            });
        LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.end');
    }

}
