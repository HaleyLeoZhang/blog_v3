<?php
namespace tests\Services;

use App\Services\Api\ExpressDeliveryApiService;
use App\Services\Api\TuringRobotApiService;
use App\Services\Api\TranslateApiService;
use App\Services\Api\ShortUrlApiService;
use LogService;


class ApiServiceTest extends \TestCase
{

    public function test_express()
    {
        $tracking_number = '801082655527271853';
        $result          = ExpressDeliveryApiService::run($tracking_number);
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', [$result]);
    }

    public function test_turning()
    {
        $trans_id = 'hlzblog-20180825-0106';
        $sentence = '你是谁啊';
        $result   = TuringRobotApiService::get_instance()
            ->set_trans_id($trans_id)
            ->set_sentence($sentence)
            ->request(TuringRobotApiService::API_TYPE_PRIVATE);
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info.API_TYPE_PRIVATE', [$result]);
        $result   = TuringRobotApiService::get_instance()
            ->set_trans_id($trans_id)
            ->set_sentence($sentence)
            ->request(TuringRobotApiService::API_TYPE_PUBLIC);
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info.API_TYPE_PUBLIC', [$result]);
    }

    public function test_short_url()
    {
        $long_url = 'https://weibo.com/';
        $short_url   = ShortUrlApiService::run($long_url);
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info.', [$short_url]);
    }


    // public function test_translate()
    // {
    //     $language_before = 'zh';
    //     $language_after = 'en';
    //     $content = '我能想到，最浪的事';
    //     $result   = TranslateApiService::get_instance()
    //         ->set_language_before($language_before)
    //         ->set_language_after($language_after)
    //         ->set_content($content)
    //         ->translate();
    //     $log = compact('content', 'result');
    //     LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', [$log]);
    // }

}
