<?php

namespace App\Http\Controllers\Admin\User;

/**
 * 用户账号管理操作相关
 */
use App\Helpers\Response;
use App\Repositories\Admin\UserRepository;
use App\Http\Controllers\BaseController;

use Illuminate\Http\Request;
class ApiController extends BaseController
{
    public function user_list_handle(Request $request){
        $filter = [
            'id' => 'required',
        ];
        $this->validate($request, $filter);
        $params = $request->all();
        UserRepository::user_list_handle($params);
        return Response::success();
    }

    public function hanld_bind_relation(Request $request){
        $filter = [
            'id' => 'required',
        ];
        $this->validate($request, $filter);
        $params = $request->all();
        UserRepository::hanld_bind_relation($params);
        return Response::success();
    }


    public function comments_update(Request $request){
        $filter = [
            'id' => 'required',
        ];
        $this->validate($request, $filter);
        $params = $request->all();
        UserRepository::comments_update($params);
        return Response::success();
    }
    

}
