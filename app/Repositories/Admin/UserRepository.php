<?php
namespace App\Repositories\Admin;

use App\Repositories\Admin\Logic\UserAdminLogic;

// ----------------------------------------------------------------------
// 仓储 - 用户信息
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class UserRepository
{

    /**
     * 查看所有用户
     * @return array
     */
    public static function user_list($params)
    {
        return UserAdminLogic::user_list($params);
    }

    /**
     * 修改用户状态
     * @return void
     */
    public static function user_list_handle($params)
    {
        UserAdminLogic::user_list_handle($params);
    }

    /**
     * 修改与管理员的绑定关系
     * @return void
     */
    public static function hanld_bind_relation($params)
    {
        UserAdminLogic::hanld_bind_relation($params);
    }

    /**
     * 查看所有用户评论
     * @return array
     */
    public static function comments($params)
    {
        return UserAdminLogic::comments($params);
    }

    /**
     * 更新用户评论
     * @return void
     */
    public static function comments_update($params)
    {
        UserAdminLogic::comments_update($params);
    }

}
