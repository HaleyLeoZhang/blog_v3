<?php

namespace App\Http\Controllers\Admin\Index;

/**
 * 用户账号管理操作相关
 */
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\IndexRepository;
use Illuminate\Http\Request;

class ViewController extends BaseController
{
    /**
     * 用户登录入口，包含登录页面显示以及登录处理
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function hall(Request $request)
    {
        $system_info = IndexRepository::hall();
        $data        = compact('system_info');
        return view('admin.index.hall', $data);
    }

    /**
     * 个人登录日志
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function login_log(Request $request)
    {
        $params =  $request->all();
        $data = IndexRepository::login_log($params);
        return view('admin.index.login_log', $data);
    }

    /**
     * 个人帐号信息修改页
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function self_info(Request $request)
    {
        $params =  $request->all();
        $data = IndexRepository::self_info($params);
        return view('admin.index.self_info', $data);
    }
}
