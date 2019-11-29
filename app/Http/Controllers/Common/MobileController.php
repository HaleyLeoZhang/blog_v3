<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\BaseController;

/**
 * 第三方登录统一处理
 */
use Illuminate\Http\Request;

class TestController extends BaseController
{
    public function mobile(Request $request)
    {
        return view('mobile/index');
    }

}
