<?php

namespace App\Http\Controllers\Auth;

/**
 * 用户账号管理操作相关
 */
use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Bussiness\Admin\AdminBussiness;
use Illuminate\Http\Request;
use Log;

class AuthApiController extends BaseController
{
    /**
     * 修改帐号状态 - 冻结、注销
     */
    public function change_user_status(Request $request)
    {
        $filter = [
            'status' => 'required',
            'email'  => 'required',
        ];
        $this->validate($request, $filter);
        $status = $request->input('status');
        $email  = $request->input('email');
        AdminBussiness::change_user_status($email, $status);
        return Response::success();
    }

    /**
     * 修改帐号各个字段
     */
    public function change_user(Request $request)
    {
        $filter = [
            'status'   => 'required',
            'email'    => 'required',
            // 'password' => 'required',
            'user_pic' => 'required',
            'truename' => 'required',
        ];
        $this->validate($request, $filter);
        $password = $request->input('password', '');
        $email    = $request->input('email');
        $user_pic = $request->input('user_pic');
        $truename = $request->input('truename');
        $status   = $request->input('status');
        AdminBussiness::change_user($password, $email, $user_pic, $truename, $status);
        return Response::success();
    }

    /**
     * 权限用户 - 显示
     * @param to_page 分页号
     */
    public function admin_user_show(Request $request)
    {
        Log::info('params', $request->all());
        $result = [];
        $result = AdminBussiness::admin_user_show();
        return Response::success($result);
    }

    /**
     * 权限列表 - 显示
     */
    public function group_list(Request $request)
    {
        $filter = [
            'admin_id' => 'required',
        ];
        $this->validate($request, $filter);
        $admin_id = $request->input('admin_id');
        $result   = AdminBussiness::group_list($admin_id);
        return Response::success($result);
    }

    /**
     * 权限列表 - 修改
     */
    public function group_edit(Request $request)
    {
        $filter = [
            'admin_id' => 'required',
            // 'group_id' => 'required',
        ];
        $this->validate($request, $filter);
        $admin_id      = $request->input('admin_id');
        $group_ids_str = $request->input('group_id');
        $result        = AdminBussiness::group_edit($admin_id, $group_ids_str);
        return Response::success($result);
    }

    /**
     * 管理员状态 - 修改
     */
    public function admin_user_status(Request $request)
    {
        $filter = [
            'admin_id' => 'required',
            'status'   => 'required',
        ];
        $this->validate($request, $filter);
        $admin_id = $request->input('admin_id', 0);
        $status   = $request->input('status', 0);
        $result   = AdminBussiness::admin_user_status($admin_id, $status);
        return Response::success($result);
    }

    /**
     * 管理员状态 - 修改
     */
    public function admin_user_del(Request $request)
    {
        $filter = [
            'admin_id' => 'required',
        ];
        $this->validate($request, $filter);
        $admin_id = $request->input('admin_id', 0);
        $result   = AdminBussiness::admin_user_del($admin_id);
        return Response::success($result);
    }

    /**
     * 管理搜索 - 显示
     */
    public function find_account(Request $request)
    {
        $filter = [
            'email' => 'required',
        ];
        $this->validate($request, $filter);
        $email  = $request->input('email');
        $result = AdminBussiness::find_account($email);
        return Response::success($result);
    }

    /**
     * 管理员状态 - 修改
     */
    public function auth_user_register(Request $request)
    {
        $filter = [
            'email'       => 'required',
            'truename'    => 'required',
            'password'    => 'required',
            're_password' => 'required',
        ];
        $this->validate($request, $filter);
        $params = $request->all();
        $result = AdminBussiness::auth_user_register($params);
        return Response::success($result);
    }

    /**
    ++++++++++++++++++++++++++++++++++++++++++++++++++++
    +                     规    则
    ++++++++++++++++++++++++++++++++++++++++++++++++++++
     */

    /**
     * 权限规则 - 显示
     */
    public function auth_rule_show(Request $request)
    {
        $result = AdminBussiness::auth_rule_show();
        return Response::success($result);
    }

    /**
     * 创建
     * @param POST  : title,rule
     * @echo String : 状态
     */
    public function auth_rule_add(Request $request)
    {
        $filter = [
            'title' => 'required',
            'rule'  => 'required',
        ];
        $this->validate($request, $filter);
        $title = $request->input('title');
        $rule  = $request->input('rule');
        $data  = AdminBussiness::auth_rule_add($title, $rule);
        return Response::success($data);
    }

    /**
     * 删除
     * @param POST  : id
     * @echo String : 状态
     */
    public function auth_rule_del(Request $request)
    {
        $filter = [
            'id' => 'required',
        ];
        $this->validate($request, $filter);
        $id = $request->input('id');
        AdminBussiness::auth_rule_del($id);
        return Response::success();
    }

    /**
     * 修改状态
     * @param POST  : id,name,title,rule,status
     * @echo String : 状态
     */
    public function auth_rule_status(Request $request)
    {
        $filter = [
            'id'     => 'required',
            'status' => 'required',
        ];
        $this->validate($request, $filter);
        $id     = $request->input('id'); // @post: 规则号
        $status = $request->input('status'); // @post: 规则开启状态
        AdminBussiness::auth_rule_status($id, $status);
        return Response::success();
    }

    /**
    ++++++++++++++++++++++++++++++++++++++++++++++++++++
    +                     管理组                       +
    ++++++++++++++++++++++++++++++++++++++++++++++++++++
     */

    /**
     * 创建
     * @param POST  : title,rules
     * @echo String : 状态
     */
    public function auth_group_add(Request $request)
    {
        $filter = [
            'title' => 'required',
            // 'rules' => 'required',
        ];
        $this->validate($request, $filter);
        $title = $request->input('title');
        $rules = $request->input('rules');
        AdminBussiness::auth_group_add($title, $rules);
        return Response::success();
    }

    /**
     * 修改 [已减小冗余]
     * @param POST  : id,value,option
     * @echo String : 状态
     */
    public function auth_group_modify(Request $request)
    {
        $filter = [
            'id'     => 'required',
            'value'  => 'required',
            'option' => 'required',
        ];
        $this->validate($request, $filter);
        $group_id = $request->input('id');
        $value    = $request->input('value');
        $option   = $request->input('option');
        AdminBussiness::auth_group_modify($group_id, $value, $option);
        return Response::success();
    }

    /**
     * 删除某组
     * @param POST  : id
     * @echo String : 状态
     */
    public function auth_group_del(Request $request)
    {
        $filter = [
            'id' => 'required',
        ];
        $this->validate($request, $filter);
        $group_id = $request->input('group_id'); // 组号
        AdminBussiness::auth_group_del($group_id);
        return Response::success();
    }

    /**
     * 查询 -> 所有分组
     * @param POST  : null
     * @echo String : 列表
     */
    public function auth_group_list(Request $request)
    {
        $result = AdminBussiness::auth_group_list();
        return Response::success($result);
    }

    /**
     * 查询 某组规则
     * @param POST  : id
     * @echo String : 列表
     */
    public function auth_one_group_rule(Request $request)
    {
        $filter = [
            'id' => 'required',
        ];
        $this->validate($request, $filter);
        $id = $request->input('id'); // 组号

        $result = AdminBussiness::auth_one_group_rule($id);
        return Response::success($result);
    }

}
