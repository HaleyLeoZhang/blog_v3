<?php

namespace App\Http\Controllers\Admin\Common;

/**
 * 公共模块
 */
use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\CommonRepository;
use Illuminate\Http\Request;

class ApiController extends BaseController
{
    public function friend_link_update(Request $request)
    {
        $params = $request->all();
        CommonRepository::friend_link_update($params);
        return Response::success();
    }
}
