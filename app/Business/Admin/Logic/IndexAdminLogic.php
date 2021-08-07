<?php
namespace App\Bussiness\Admin\Logic;

use App\Models\AdminAuth\Admin;
use App\Models\Logs\AdminLoginLog;
use App\Helpers\Token;
use App\Services\Auth\InfoAuthService;

class IndexAdminLogic
{
    /**
     * @return array
     */
    public static function hall():array
    {
        $systemInfo['phpVersion']       = PHP_VERSION;
        $systemInfo['runOS']            = PHP_OS;
        $systemInfo['maxUploadSize']    = ini_get('upload_max_filesize');
        $systemInfo['maxExecutionTime'] = ini_get('max_execution_time');
        $systemInfo['hostName']         = '';
        if (isset($_SERVER['SERVER_NAME'])) {
            $systemInfo['hostName'] .= $_SERVER['SERVER_NAME'] . ' / ';
        }
        if (isset($_SERVER['SERVER_ADDR'])) {
            $systemInfo['hostName'] .= $_SERVER['SERVER_ADDR'] . ' / ';
        }
        if (isset($_SERVER['SERVER_PORT'])) {
            $systemInfo['hostName'] .= $_SERVER['SERVER_PORT'];
        }
        $systemInfo['serverInfo'] = '';
        if (isset($_SERVER['SERVER_SOFTWARE'])) {
            $systemInfo['serverInfo'] = $_SERVER['SERVER_SOFTWARE'];
        }
        return $systemInfo;
    }

    /**
     * @return array
     */
    public static function login_log_td($params):array
    {
        $chain = AdminLoginLog::where('admin_id', \CommonService::$admin->id);

        $params['start_time'] = $params['start_time'] ?? '';
        $params['end_time']   = $params['end_time'] ?? '';
        if ('' != $params['start_time']) {
            $chain = $chain->where('created_at', '>=', $params['start_time']);
        }
        if ('' != $params['end_time']) {
            $chain = $chain->where('created_at', '<=', $params['end_time']);
        }
        $render = $chain->orderBy('id', 'desc')
            ->paginate(\CommonService::END_INDEX_PAGE_SIZE);
        // 处理数据
        $ths = [];
        foreach ($render as $log) {
            $temp = [];
            $log->admin(); // 因为 日志库与主业务会分开
            $temp['id']         = $log->id;
            $temp['truename']   = $log->truename;
            $temp['email']      = $log->email;
            $temp['ip']         = $log->ip;
            $temp['location']   = $log->location;
            $temp['updated_at'] = $log->updated_at;
            $temp['created_at'] = $log->created_at;
            $ths[]              = $temp;
        }
        $render->appends($params);
        return [
            $ths,
            $render,
        ];

    }

    /**
     * @return array
     */
    public static function login_log_th($params):array
    {

        $th   = [];
        $th[] = 'ID';
        $th[] = '用户名';
        $th[] = '用户邮箱';
        $th[] = 'IP';
        $th[] = '地理位置';
        $th[] = '修改时间';
        $th[] = '创建时间';
        return $th;

    }


    /**
     * 修改密码
     * - 修改后，清空已经登录过的帐号信息
     * @return void
     */
    public static function user_password_edit($password)
    {
        if( strlen($password) < 6 ){
            throw new \ApiException("密码至少得6位哟！");
        }
        // Logic
        $secret            = Token::rand_str(4);
        $password_add_salt = md5($password . $secret);
        $params            = [
            'secret'         => $secret, // 密码 - 盐值，每次生成密码时会重置
            'password'       => $password_add_salt, // 密码加盐后
        ];
        // - 修改密码
        $admin = \CommonService::$admin;
        $admin->secret = $secret; // 密码 - 盐值，每次生成密码时会重置
        $admin->password = $password_add_salt; // 密码加盐后
        $admin->save();
        // - 清空当前帐号登录信息
        InfoAuthService::delete($admin->remember_token);
    }

}
