<?php
namespace App\Repositories\Admin\Logic;

use App\Models\AdminAuth\Admin;
use App\Models\Logs\AdminLoginLog;

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

}
