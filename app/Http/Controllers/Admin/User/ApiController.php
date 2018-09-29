<?php

namespace App\Http\Controllers\Admin\User;

/**
 * 用户账号管理操作相关
 */
use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\Request;

class ApiController extends BaseController
{
    /**
     * @api {post} /admin/user/user_list_handle 修改用户状态
     * @apiName user_list_handle
     * @apiGroup user
     *
     * @apiDescription  修改用户状态
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 200,
     *     "message": "请求成功",
     *     "data": null
     * }
     */
    public function user_list_handle(Request $request)
    {
        $filter = [
            'id' => 'required',
        ];
        $this->validate($request, $filter);
        $params = $request->all();
        UserRepository::user_list_handle($params);
        return Response::success();
    }

    /**
     * @api {post} /admin/user/hanld_bind_relation 修改与管理员的绑定关系
     * @apiName hanld_bind_relation
     * @apiGroup user
     *
     * @apiDescription  修改与管理员的绑定关系
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 200,
     *     "message": "请求成功",
     *     "data": null
     * }
     */
    public function hanld_bind_relation(Request $request)
    {
        $filter = [
            'id' => 'required',
        ];
        $this->validate($request, $filter);
        $params = $request->all();
        UserRepository::hanld_bind_relation($params);
        return Response::success();
    }

    /**
     * @api {post} /admin/user/comments_update 更新用户评论
     * @apiName comments_update
     * @apiGroup user
     *
     * @apiDescription  更新用户评论
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 200,
     *     "message": "请求成功",
     *     "data": null
     * }
     */
    public function comments_update(Request $request)
    {
        $filter = [
            'id' => 'required',
        ];
        $this->validate($request, $filter);
        $params = $request->all();
        UserRepository::comments_update($params);
        return Response::success();
    }

}
