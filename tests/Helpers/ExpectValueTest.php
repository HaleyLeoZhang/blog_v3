<?php
namespace tests\Helpers;

use App\Helpers\ExpectValue;
use LogService;

class ExpectValueTest extends \TestCase
{

    /**
     * 计算期望值
     */
    public function test_compute()
    {
        LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.start');
        $arr = [
            10,
            9,
            8,
            9.554,
            9,
            6,
            10,
            7,
        ];
        $expect = ExpectValue::compute($arr);
        $log    = compact(
            'expect'
        );
        LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.info ', $log);
        // $arr[]  = $expect;
        // $expect = ExpectValue::compute($arr);
        // $log    = compact(
        //     'expect'
        // );
        // LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.info ', $log);
        LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.end');
    }
}
