<?php
namespace App\Bussiness\Admin;

use App\Bussiness\Admin\Logic\CommonAdminLogic;
use App\Bussiness\Admin\Logic\ManageAdminLogic;

// ----------------------------------------------------------------------
// 仓储 - 管理员
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class AdminBussiness
{
    /**
     * 邮箱登录-滑块验证
     * @param string $account 用户的帐号：目前暂定为邮箱号
     * @param string $password 用户的密码
     * @return array
     */
    public static function login_slide_verify($account, $password)
    {
        $data = CommonAdminLogic::login_slide_verify($account, $password);
        return $data;
    }

    /**
     * 邮箱登录-谷歌验证
     * @param string $account 用户的帐号：目前暂定为邮箱号
     * @param string $password 用户的密码
     * @param string $google_captchar 谷歌验证码
     * @return array
     */
    public static function login_google($account, $password, $google_captchar)
    {
        $data = CommonAdminLogic::login_google($account, $password, $google_captchar);
        return $data;
    }

    /**
     * 绑定谷歌验证码
     * @param string eamil 邮箱
     * @param string secret 谷歌验证码
     * @return void
     */
    public static function register_google_captchar($email, $secret)
    {
        CommonAdminLogic::register_google_captchar($email, $secret);
    }

    /**
     * 注销
     * @param string $account 用户的帐号：目前暂定为邮箱号
     * @param string $password 用户的密码
     * @param string $google_captchar 谷歌验证码
     * @return array
     */
    public static function logout($token)
    {
        CommonAdminLogic::logout($token);
    }

    /**
     * 修改帐号状态 - 冻结、注销
     * @param string email 邮箱号只能对应一个账号
     * @param string status 用户状态
     * @return void
     */
    public static function change_user_status($email, $status)
    {
        ManageAdminLogic::change_user_status($email, $status);
        CommonAdminLogic::logout_admin($email);
    }

    /**
     * 修改帐号 - 密码、状态
     * @param string password 生密码
     * @param string email 邮箱号只能对应一个账号
     * @param string user_pic 用户头像地址
     * @param string truename 用户真实姓名
     * @param string status 用户状态
     * @return void
     */
    public static function change_user($password, $email, $user_pic, $truename, $status)
    {
        ManageAdminLogic::change_user($password, $email, $user_pic, $truename, $status);
        CommonAdminLogic::logout_admin($email);
    }

    /**
     * 查看管理员
     * @return Object
     */
    public static function admin_user_show()
    {
        $page_data = ManageAdminLogic::admin_user_show();
        return $page_data;
    }

    /**
     * 超级管理员，查看权限组
     * @param string admin_id 管理员ID
     * @return array
     */
    public static function group_list($admin_id)
    {
        $result = ManageAdminLogic::group_list($admin_id);
        return $result;
    }

    /**
     * 超级管理员，修改管理员分组
     * @param string admin_id 管理员ID
     * @param string group_ids_str 组分类，以逗号隔开
     * @return void
     */
    public static function group_edit($admin_id, $group_ids_str)
    {
        ManageAdminLogic::group_edit($admin_id, $group_ids_str);
    }

    /**
     * 超级管理员，修改管理员帐号状态
     * @param string admin_id 管理员ID
     * @param string status 帐号状态
     * @return bool
     */
    public static function admin_user_status($admin_id, $status): bool
    {
        $result = ManageAdminLogic::admin_user_status($admin_id, $status);
        return $result;
    }

    /**
     * 超级管理员，软删除管理员
     * @param string admin_id 管理员ID
     * @return bool
     */
    public static function admin_user_del($admin_id): bool
    {
        $result = ManageAdminLogic::admin_user_del($admin_id);
        return $result;
    }

    /**
     * 超级管理员，搜素帐号
     * @param string $_email 管理员帐号，目前以邮箱的形式展示的
     * @return array
     */
    public static function find_account($_email)
    {
        $result = ManageAdminLogic::find_account($_email);
        return $result;
    }

    /**
     * 超级管理员，注册后台用户帐号
     * @param array $params 管理员注册参数
     * @return bool
     */
    public static function auth_user_register(&$params): bool
    {
        list($password, $email, $user_pic, $truename) = ManageAdminLogic::auth_user_register_filter($params);

        $result = ManageAdminLogic::create_user($password, $email, $user_pic, $truename);
        return $result;
    }

    /**
     * 后台管理员登录日志
     * @param string password 生密码
     * @param string email 邮箱号只能对应一个账号
     * @param string user_pic 用户头像地址
     * @param string truename 用户真实姓名
     * @return Object
     */
    public static function auth_admin_logs(&$params)
    {
        $result = ManageAdminLogic::auth_admin_logs($params);
        return $result;
    }

    // --- 权限规则 模块

    /**
     * 权限规则列表
     * @return array
     */
    public static function auth_rule_show()
    {
        $result = ManageAdminLogic::auth_rule_show();
        return $result;
    }

    /**
     * 权限规则列表
     * @param string $title 规则标题，一般用于展示
     * @param string $rule  具体规则，一般为路由
     * @return array
     */
    public static function auth_rule_add($title, $rule)
    {
        $result = ManageAdminLogic::auth_rule_add($title, $rule);
        return $result;
    }

    /**
     * 删除某个权限规则
     * @param string $id  某个权限规则的ID
     * @return void
     */
    public static function auth_rule_del($id)
    {
        ManageAdminLogic::auth_rule_del($id);
    }

    /**
     * 修改某个权限规则的状态
     * @param string $id      某个权限规则的ID
     * @param string $status  某个权限规则的状态值
     * @return void
     */
    public static function auth_rule_status($id, $status)
    {
        ManageAdminLogic::auth_rule_status($id, $status);
    }

    // --- 管理组 模块

    /**
     * 修改某个权限规则的状态
     * @param string $title  即将添加的管理组名称
     * @param string $rules  选中的规则列表
     * @return void
     */
    public static function auth_group_add($title, $rules)
    {
        ManageAdminLogic::auth_group_add($title, $rules);
    }

    /**
     * 修改某个权限组的 状态、规则名、选中的规则列表
     * @param string $group_id  某个权限组的ID
     * @param string $value   打算修改的值
     * @param string $option  打算修改的字段
     * @return void
     */
    public static function auth_group_modify($group_id, $value, $option)
    {
        ManageAdminLogic::auth_group_modify($group_id, $value, $option);
    }

    /**
     * 删除某个权限组
     * @param string $group_id  某个权限组的ID
     * @return void
     */
    public static function auth_group_del($group_id)
    {
        ManageAdminLogic::auth_group_del($group_id);
    }

    /**
     * 获取权限组列表
     * @return array
     */
    public static function auth_group_list()
    {
        $result = ManageAdminLogic::auth_group_list();
        return $result;
    }

    /**
     * 查看某个权限组的所有规则
     * @param string $id  某个权限组的ID
     * @return array
     */
    public static function auth_one_group_rule($id)
    {
        $result = ManageAdminLogic::auth_one_group_rule($id);
        return $result;
    }

}
