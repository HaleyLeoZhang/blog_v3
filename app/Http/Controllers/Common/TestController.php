<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\BaseController;

/**
 * 第三方登录统一处理
 */
use Illuminate\Http\Request;

class TestController extends BaseController
{
    public function slide_verify(Request $request)
    {
        return view('test/slide_verify/index');
    }

    public function express_delivery(Request $request)
    {
        return view('module/test/express_delivery');
    }

    public function short_url(Request $request)
    {
        return view('module/test/short_url');
    }

}
