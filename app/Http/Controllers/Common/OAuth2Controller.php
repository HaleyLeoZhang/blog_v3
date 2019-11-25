<?php

namespace App\Http\Controllers\Common;

use App\Bussiness\OAuth2\OAuth2Bussiness;

/**
 * 第三方登录统一处理
 */
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class OAuth2Controller extends BaseController
{
    /**
     * 重定向前，记录用户
     */
    public function redirect(Request $request)
    {
        $filter = [
            'gateway' => 'required',
        ];
        $this->validate($request, $filter);
        $oauth_type = $request->input('gateway');
        $redirect   = OAuth2Bussiness::get_third_login_url($oauth_type);

        $redirect_after_login = $_SERVER['HTTP_REFERER'] ?? '/';

        $render = compact('redirect', 'redirect_after_login');

        return view('login/oauth2/redirect', $render);
    }

    /**
     * QQ 回调
     */
    public function qq(Request $request)
    {
        $params     = $request->all();
        $oauth_type = 'qq';
        return $this->callback($params, $oauth_type);
    }

    /**
     * Sina 回调
     */
    public function sina(Request $request)
    {
        $params     = $request->all();
        $oauth_type = 'sina';
        return $this->callback($params, $oauth_type);
    }

    /**
     * Github 回调
     */
    public function github(Request $request)
    {
        $params     = $request->all();
        $oauth_type = 'github';
        return $this->callback($params, $oauth_type);
    }

    /**
     * Wechat 回调
     */
    public function wechat(Request $request)
    {
        $params     = $request->all();
        $oauth_type = 'wechat';
        return $this->callback($params, $oauth_type);
    }

    /**
     * Wechat 回调
     */
    protected function callback($params, $oauth_type)
    {
        $render = OAuth2Bussiness::callback($params, $oauth_type);
        return view('login/oauth2/callback', $render);
    }

    /**
     * 用户设置 cookie
     */
    public function set_cookie(Request $request)
    {
        \LogService::debug('set_cookie.request:', $request->all());
        $filter = [
            'token_name'  => 'required',
            'token_value' => 'required',
            'expire_at'   => 'required',
            'redirect'    => 'required',
        ];
        $this->validate($request, $filter);
        $token_name  = $request->input('token_name');
        $token_value = $request->input('token_value');
        $expire_at   = $request->input('expire_at');
        $redirect    = $request->input('redirect');
        // - - Browser端数据清洗
        setcookie($token_name, $token_value, $expire_at, '/');
        return redirect('oauth2/get_cookie?redirect=' . urlencode($redirect));
    }

    /**
     * 客户端生效 cookie ，并重定向到之前的页面
     */
    public function get_cookie(Request $request)
    {
        $filter = [
            'redirect' => 'required',
        ];
        $this->validate($request, $filter);
        $redirect = $request->input('redirect');
        return redirect(urldecode($redirect));
    }

    /**
     * 清空用户所有 Cookie
     */
    public function logout(Request $request)
    {
        $render = OAuth2Bussiness::logout();
        // --- Browser端数据清洗
        $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
        return redirect($redirect);
    }

}
