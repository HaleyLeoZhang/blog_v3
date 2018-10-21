<?php
namespace App\Repositories\Admin\Logic;

use App\Models\AdminAuth\Admin;
use App\Repositories\Log\LogRepository;
use App\Services\Auth\InfoAuthService;
use App\Services\Crypt\RsaCryptService;
use App\Services\Verify\SlideVerifyService;

class CommonAdminLogic
{
    /**
     * @return array
     */
    public static function login_slide_verify($account, $password)
    {
        $account       = self::decrypt($account);
        $password      = self::decrypt($password);
        $verify_result = SlideVerifyService::instance('is_pass');
        // 验证码没通过？
        if ($verify_result['status']) {
            throw new \ApiException($verify_result['out']);
        }
        // 帐号存在？
        $admin = Admin::where('email', $account)
            ->orderBy('id', 'desc')
            ->first();
        if (!$admin) {
            throw new \ApiException(null, \Consts::USER_ACCOUNT_OR_PASSWORD_ERROR);
        }
        return self::login_logic($admin, $account, $password);

    }

    /**
     * @return array
     */
    public static function login_google($account, $password, $google_captchar)
    {
        $account         = self::decrypt($account);
        $password        = self::decrypt($password);
        $google_captchar = self::decrypt($google_captchar);
        // 帐号存在？
        $admin = Admin::where('email', $account)
            ->orderBy('id', 'desc')
            ->first();
        if (!$admin) {
            throw new \ApiException(null, \Consts::USER_ACCOUNT_OR_PASSWORD_ERROR);
        }

        // 谷歌验证码
        if ('' == $admin->google_captchar) {
            throw new \ApiException(null, \Consts::USER_GOOGLE_CATCHAR_NOT_CREATE);
        } elseif (!\Google::CheckCode($admin->google_captchar, $google_captchar)) {
            throw new \ApiException("谷歌验证码不正确");
        }
        return self::login_logic($admin, $account, $password);

    }

    /**
     * 绑定谷歌验证码
     * @param string eamil 邮箱
     */
    public static function register_google_captchar($email, $secret)
    {
        $passport_info = \CommonService::$passport_system[\CommonService::LOGIN_TYPE_END_SYSTEM];

        if ('google' != $passport_info['login_type']) {
            throw new \ApiException("当前未开启谷歌验证，请开启后重试");
        }
        $admin = Admin::where('email', $email)
            ->orderBy('id', 'desc')
            ->first();
        if ('' != $admin->google_captchar) {
            throw new \ApiException("该帐号已绑定过谷歌验证码");
        } else {
            $admin->google_captchar = $secret;
            $admin->save();
        }
    }

    /**
     * 注销
     * @param string eamil 邮箱
     */
    public static function logout($token)
    {
        InfoAuthService::set_token(\CommonService::LOGIN_TYPE_END_SYSTEM, $token);
        InfoAuthService::delete();
    }

    /**
     * 管理员登录逻辑
     * @param \App\Models\AdminAuth\Admin $admin 管理员帐号
     * @param string $account 用户的帐号
     * @param string $password 用户的密码
     */
    protected static function login_logic($admin, $account, $password)
    {
        // 生密码数据解密 - TODO
        // $password = RsaService::decrypt($password);
        // 密码与盐值计算 md5
        $password_add_salt = md5($password . $admin->secret);
        // 比对密码结果？
        if ($password_add_salt != $admin->password) {
            throw new \ApiException(null, \Consts::USER_ACCOUNT_OR_PASSWORD_ERROR);
        }
        // 帐号状态判断
        if ($admin->status != Admin::STATUS_NORMAL_USER) {
            $message = Admin::$message_status[$admin->status];
            throw new \ApiException($message, \Consts::FAILED);
        }
        // 删除上一次的登录信息
        InfoAuthService::delete($admin->remember_token);

        // 写入用户 mobile、token、user_id 到缓存信息
        $token      = InfoAuthService::get_rand_token();
        $token_info = [
            'id'    => $admin->id,
            'email' => $admin->email,
        ];
        $admin->remember_token = $token;
        $admin->save();
        InfoAuthService::set_token(\CommonService::LOGIN_TYPE_END_SYSTEM, $token);
        InfoAuthService::token_info($token_info);
        // 写入登录日志
        LogRepository::admin_login_log($admin->id);
        // 返回 token 给客户端
        return [
            'token' => $token,
        ];
    }

    /**
     * 数据解密
     * @param string $param 待解密的参数
     * @return string
     */
    public static function decrypt($param)
    {
        $temp      = urldecode($param);
        $real_data = RsaCryptService::decrypt($temp);
        return $real_data;
    }
}
