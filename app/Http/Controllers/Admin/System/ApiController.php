<?php

namespace App\Http\Controllers\Admin\System;

/**
 * 公共模块
 */
use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Bussiness\Admin\SystemBussiness;
use Illuminate\Http\Request;

class ApiController extends BaseController
{
    public function pic_bed_update(Request $request)
    {
        $params = $request->all();
        SystemBussiness::pic_bed_update($params);
        return Response::success();
    }
}
