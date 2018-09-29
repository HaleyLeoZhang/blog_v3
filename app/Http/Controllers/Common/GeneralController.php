<?php

namespace App\Http\Controllers\Common;

/**
 * 各种用户账号管理操作相关
 */
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class GeneralController extends BaseController
{
    /**
     * 大事记
     * @return \Illuminate\View\View
     */
    public function memorabilia(Request $request)
    {
        return view('module/flexible/memorabilia');
    }

}
