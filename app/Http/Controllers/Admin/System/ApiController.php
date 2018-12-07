<?php

namespace App\Http\Controllers\Admin\System;

/**
 * 公共模块
 */
use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\SystemRepository;
use Illuminate\Http\Request;

class ApiController extends BaseController
{
    public function pic_bed_update(Request $request)
    {
        $params = $request->all();
        SystemRepository::pic_bed_update($params);
        return Response::success();
    }
}
