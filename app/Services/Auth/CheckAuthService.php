<?php
namespace App\Services\Auth;

use App\Services\Auth\BaseAuthService;

// ----------------------------------------------------------------------
// 权限管理 For 云天河博客后台 - 权限鉴别
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class CheckAuthService
{

    /**
     * 满足条件,则输出相应结果 - 一般控制 页面里的按钮显示
     * @param int     : admin_id 管理员ID
     * @param String  : rule 要验证的规则名称,一般是“模块名/控制器名/方法”
     * @param any     : true 符合规则后,执行的代码
     * @param String  : false 不符合规则的,执行代码,默认为抛出字符串‘’
     * @param String  : relation 默认值为‘or’,表示有一条规则满足条件即可,‘and’表示所有规则都得满足
     * @return String : 对应true或者false情况,输出的值
     */
    public static function check($admin_id, $rule, $true, $false = '', $relation = 'or')
    {
        // 如果是超级管理员,默认通过验证
        if (in_array($admin_id, config('hlz_auth.SUPER_LIST'))) {
            // Log::info('是超级管理员');
            return $true;
        } else {
            $auth = new BaseAuthService();
            // Log::info('检测权限中 - 规则名：'. $rule);
            $result = $auth->check($rule, $admin_id, 1, 'url', $relation);
            if ($result) {
                return $true;
            } else {
                // Log::info('您没有该访问权限：', [
                //     'rule' => $rule,
                //     'admin_id' => $admin_id,
                // ]);
                return $false;
            }
        }
    }

    /**
     * 区分 ajax 与 页面请求的返回
     * @param  \Illuminate\Http\Request  $request
     */
    public static function error_response($request, $login_type)
    {
        // Ajax？
        if ($request->ajax()) {
            throw new \ApiException(null, \Consts::ACCESS_FORBIDDEN);
        } else {
            $passport_info =\CommonService::$passport_system[$login_type];
            return redirect($passport_info['redirect_url']);
        }
    }
}
