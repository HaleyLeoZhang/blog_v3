<?php

namespace tests\Services;

use App\Services\Search\InnerSearchService;
use LogService;

class InnerSearchServiceTest extends \TestCase
{
    public function test_run()
    {
        $keyword = '消息';
        $res = InnerSearchService::run($keyword);
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', [$res]);
    }
}