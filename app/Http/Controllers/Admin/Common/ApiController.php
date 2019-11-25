<?php

namespace App\Http\Controllers\Admin\Common;

/**
 * 公共模块
 */
use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Bussiness\Admin\CommonBussiness;
use Illuminate\Http\Request;

class ApiController extends BaseController
{
    public function friend_link_update(Request $request)
    {
        $params = $request->all();
        CommonBussiness::friend_link_update($params);
        return Response::success();
    }
}
