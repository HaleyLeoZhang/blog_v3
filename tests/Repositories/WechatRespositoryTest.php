<?php
namespace tests\Repositories;

use App\Repositories\Wechat\Logic\ReceiveChatLogic;
use LogService;

class WechatRespositoryTest extends \TestCase
{

    public function test_text()
    {
        LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.start');
        $text   = '1';
        $result = ReceiveChatLogic::text($text);
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', $result);
        LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.end');
    }

}
