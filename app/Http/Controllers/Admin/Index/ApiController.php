<?php

namespace App\Http\Controllers\Admin\Index;

/**
 * 用户账号管理操作相关
 */
use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\IndexRepository;
use Illuminate\Http\Request;

class ApiController extends BaseController
{
    public function user_password_edit(Request $request)
    {
        $password = $request->input('password', '');
        IndexRepository::user_password_edit($password);
        return Response::success();
    }
}
