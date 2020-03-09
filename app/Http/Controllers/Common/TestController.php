<?php

namespace App\Http\Controllers\Common;

/**
 * Lab 页面
 */

use App\Http\Controllers\BaseController;

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
