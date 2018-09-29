<?php

namespace App\Http\Controllers\Auth;

/**
 * 各种用户账号管理操作相关
 */
use App\Helpers\Response;
use App\Helpers\Token;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\AdminRepository;
use Illuminate\Http\Request;

class AccountController extends BaseController
{
    protected $passport_info = null;

    public function __construct()
    {
        $this->passport_info = \CommonService::$passport_system[\CommonService::LOGIN_TYPE_END_SYSTEM];
    }

    /**
     * 管理员登录入口
     * @param \Illuminate\Http\Request $request
     */
    public function login(Request $request)
    {
        switch ($this->passport_info['login_type']) {
            case 'slide_verify':
                return view('login.admin.slide');
            case 'google':
                return view('login.admin.google');
            default: // 默认滑动验证码
                return view('login.admin.slide');
        }

    }

    /**
     * @api {post} /admin/login_slide_verify 管理员登录-滑块验证
     * @apiName login_slide_verify
     * @apiGroup Account
     *
     * @apiParam {string} account 用户的帐号：目前暂定为邮箱号
     * @apiParam {string} password 用户的密码
     *
     * @apiDescription  后台帐号登录（所有参数：先被经过 RSA 公钥加密，后被前端 encodeURIComponent 加密）
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 10003,
     *     "message": "帐号或者密码不正确",
     *     "data": null
     * }
     */
    public function login_slide_verify(Request $request)
    {
        $filter = [
            'account'  => 'required',
            'password' => 'required',
        ];
        $this->validate($request, $filter);
        $account  = $request->input('account');
        $password = $request->input('password');
        // - 身份认证
        $result = AdminRepository::login_slide_verify($account, $password);
        $info   = $this->login_common_handle($result);
        return Response::success($info);
    }

    /**
     * @api {post} /admin/login_google 管理员登录-谷歌验证
     * @apiName login_google
     * @apiGroup Account
     *
     * @apiParam {string} account 用户的帐号：目前暂定为邮箱号
     * @apiParam {string} password 用户的密码
     * @apiParam {string} google_captchar 谷歌验证码
     *
     * @apiDescription  后台帐号登录（所有参数：先被经过 RSA 公钥加密，后被前端 encodeURIComponent 加密）
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     */
    public function login_google(Request $request)
    {
        $filter = [
            'account'         => 'required',
            'password'        => 'required',
            'google_captchar' => 'required',
        ];
        $this->validate($request, $filter);
        $account         = $request->input('account');
        $password        = $request->input('password');
        $google_captchar = $request->input('google_captchar');
        // - 身份认证
        $result = AdminRepository::login_google($account, $password, $google_captchar);
        // 公共身份写入
        $info = $this->login_common_handle($result);
        return Response::success($info);
    }

    protected function login_common_handle($result)
    {
        // - 写入身份
        $expire_at = time() + $this->passport_info['token_expire'];
        \LogService::debug('TOKEN_EXPIRE_AT:' . $expire_at, $result);
        $data = [
            'token_name'  => $this->passport_info['token_name'],
            'token_value' => $result['token'],
            'expire_at'   => $expire_at,
        ];
        $info                 = [];
        $info['quert_string'] = http_build_query($data);
        return $info;
    }

    /**
     * 用户设置 cookie
     */
    public function set_cookie(Request $request)
    {
        \LogService::debug('set_cookie.request:' , $request->all() );
        $filter = [
            'token_name'  => 'required',
            'token_value' => 'required',
            'expire_at'   => 'required',
        ];
        $this->validate($request, $filter);
        $token_name  = $request->input('token_name');
        $token_value = $request->input('token_value');
        $expire_at   = $request->input('expire_at');
        // - - Browser端数据清洗
        setcookie($token_name, $token_value, $expire_at, '/');
        // header('Location: /admin/getcookie');
        // $foreverCookie = \Cookie::forever($token_name, $token_value);
        return redirect('admin/get_cookie');
    }

    /**
     * 用户获取 cookie
     */
    public function get_cookie(Request $request)
    {
        return redirect($this->passport_info['page_success']);
    }

    /**
     * 用户登出
     */
    public function logout()
    {
        // - 清空身份
        // --- 服务端数据清洗
        $token = $_COOKIE[$this->passport_info['token_name']] ?? '';
        AdminRepository::logout($token);
        // --- Browser端数据清洗
        setcookie($this->passport_info['token_name'], '', -1, '/');
        return redirect($this->passport_info['redirect_url']);

    }

    /**
     * 谷歌验证码
     */
    public function google_captchar(Request $request)
    {
        $message = ''; // 错误信息
        if ($request->isMethod('post')) {
            if (empty($request->bind_secret) && strlen($request->bind_secret) != 6) {
                return back()->with('msg', '请正确输入手机上google验证码 ！')->withInput();
            }
            \Log::info('request:', [$request->all()]);
            // google密钥，绑定的时候为生成的密钥；如果是绑定后登录，从数据库取以前绑定的密钥
            $google      = $request->google;
            $bind_secret = $request->bind_secret;
            $email       = $request->email;
            // 验证验证码和密钥是否相同
            if (\Google::CheckCode($google, $bind_secret)) {
                // 绑定场景：绑定成功，向数据库插入google参数，跳转到登录界面让用户登录
                AdminRepository::register_google_captchar($email, $google);
                // 登录认证场景：认证成功，执行认证操作
                return redirect($this->passport_info['redirect_url']);
            } else {
                // 绑定场景：认证失败，返回重新绑定，刷新新的二维码
                $message = '请正确输入手机上google验证码';
            }
        }
            // 创建谷歌验证码
            $createSecret = \Google::CreateSecret();
            $email        = $request->input('email', '-');
            $message        = $request->input('message', $message);
            $data         = compact('createSecret', 'email', 'message');
            // 您自定义的参数，随表单返回
            return view('login.google.google', $data);
    }

}
