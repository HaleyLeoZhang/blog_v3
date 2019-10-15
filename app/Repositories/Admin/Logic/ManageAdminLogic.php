<?php
namespace App\Repositories\Admin\Logic;

use App\Helpers\Page;
use App\Helpers\Token;
use App\Models\AdminAuth\Admin;
use App\Models\Logs\AdminLoginLog;
use DB;
use CommonService;

class ManageAdminLogic
{
    const PAGE_SIZE = 20; // 分页尺寸

    /**
     * 超级管理员才允许
     */
    public static function check_super()
    {
        // - 超级管理员才允许
        if (!in_array(\CommonService::$admin->id, config('hlz_auth.SUPER_LIST'))) {
            throw new \ApiException(null, \Consts::ACCESS_FORBIDDEN);
        }
    }

    // - Logic

    /**
     * 修改帐号状态 - 冻结、注销
     * @param string email 邮箱号只能对应一个账号
     * @param string status 用户状态
     * @return void
     */
    public static function change_user_status($email, $status)
    {
        self::check_super();
        if (!in_array($status, Admin::$status_list)) {
            throw new \ApiException(null, \Consts::USER_ACCOUNT_STATUS_NOT_EXISTS);
        }
        Admin::where('email', $email)
            ->orderBy('id', 'desc')
            ->limit(1)
            ->update([
                'status' => $status,
            ]);
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
        self::check_super();
        if (!in_array($status, Admin::$status_list)) {
            throw new \ApiException(null, \Consts::USER_ACCOUNT_STATUS_NOT_EXISTS);
        }

        $data = [
            // 'email'    => $email, // 邮箱号只能对应一个账号，不可更改
            'user_pic' => $user_pic, // 用户头像地址
            'truename' => $truename, // 用户真实姓名
            'status'   => $status, // 用户状态
        ];

        // 密码项不为空时，更新密码
        if ('' != $password) {
            $secret            = Token::rand_str(4);
            $password_add_salt = md5($password . $secret);
            // 更新密码相关
            $data['secret']   = $secret; // 密码 - 盐值，每次生成密码时会重置
            $data['password'] = $password_add_salt; // 密码加盐后
        }
        Admin::where('email', $email)->update($data);
    }
    /**
     * 查看管理员
     * @return Object
     */
    public static function admin_user_show()
    {
        self::check_super();
        $page = new Page('
            Select id, truename, user_pic, status, email, created_at, updated_at
            From `admins`
            Where `status` != ?
            Order By `id` DESC
            limit ?,?
        ', [Admin::STATUS_DELETED_USER]);
        $page->is_render = true; // 如果需要渲染，将值设置为 true
        $page->page_size = self::PAGE_SIZE; // 每页显示的数据条数，默认 15
        $page_data       = $page->get_result();
        return $page_data;
    }

    public static function group_list($admin_id)
    {
        self::check_super();
        //查询
        $group_list = DB::select('
            Select `id`, `title`
            From `hlz_auth_group`
            Where `status` = 1
        ', []);
        $now_group = DB::select('
            Select a.`title`,a.`id`
            From `hlz_auth_group` as a
            Inner Join `hlz_auth_group_access` as b
            On a.`id` = b.`group_id`
            Where b.`uid` = ?
        ', [$admin_id]);
        $result['info'] = [
            'group_list' => &$group_list,
            'now_group'  => &$now_group,
            'admin_id'   => $admin_id,
        ];
        return $result;
    }

    public static function group_edit($admin_id, $group_ids_str)
    {
        self::check_super();
        $group_ids = explode(',', $group_ids_str); //@post: 分组号，形如 1,21,6,10
        // 组装 过滤sql数据
        $insert_sql = '';
        for ($i = 0; $i < count($group_ids); $i++) {
            $insert_sql .= ' (' . $admin_id . ',' . intval($group_ids[$i]) . ') ';
            if ($i < count($group_ids) - 1) {
                $insert_sql .= ', ';
            }
        }
        // 删除原来的
        DB::delete('
            Delete From `hlz_auth_group_access`
            Where `uid` = ?
        ', [$admin_id]);
        // 录入现在的
        DB::insert('
            Insert into `hlz_auth_group_access`
            (`uid`,`group_id`)Values ' . $insert_sql . '
        ', []);
    }

    public static function admin_user_status($admin_id, $status)
    {
        self::check_super();
        $result = Admin::where('id', $admin_id)
            ->update([
                'status' => $status,
            ]);
        return true;
    }

    public static function admin_user_del($admin_id)
    {
        $data           = [];
        $data['status'] = Admin::STATUS_DELETED_USER;
        $result         = Admin::where('id', $admin_id)
            ->update($data);
        return true;
    }

    public static function find_account($_email)
    {
        self::check_super();
        $email = '%' . $_email . '%'; //@post: 职员帐号
        // 查询
        $result['list'] = Admin::select('id', 'truename', 'user_pic', 'status', 'email', 'created_at', 'updated_at')
            ->whereRaw('`email` like "' . $email . '"')
            ->where('status', '!=', Admin::STATUS_DELETED_USER)
            ->get();
        return $result;
    }

    public static function auth_user_register_filter(&$params)
    {
        self::check_super();
        // - 数据验证
        $reg          = '/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/';
        $match_result = preg_match($reg, $params['email']);
        if (!$match_result) {
            throw new \ApiException("邮箱格式不正确");
        }

        if ($params['password'] != $params['re_password']) {
            throw new \ApiException("两次输入的密码不一致");
        }
        $str_len = mb_strlen($params['password']);
        if ($str_len < 6 || $str_len > 25) {
            throw new \ApiException("密码长度不对");
        }
        // - 注册
        $data     = [];
        $password = $params['password'];
        $email    = $params['email'];
        $user_pic = Admin::get_rand_pic();
        $truename = $params['truename'];
        return [
            $password,
            $email,
            $user_pic,
            $truename,
        ];
    }

    /**
     * 手机号或者邮箱注册
     * @param string password 生密码
     * @param string email 邮箱号只能对应一个账号
     * @param string user_pic 用户头像地址
     * @param string truename 用户真实姓名
     * @return bool
     */
    public static function create_user($password, $email, $user_pic, $truename)
    {
        self::check_super();
        // 帐号存在？
        $admin = Admin::where('email', $email)
            ->where('status', '!=', Admin::STATUS_DELETED_USER)
            ->orderBy('id', 'desc')
            ->first();
        if ($admin) {
            throw new \ApiException(null, \Consts::USER_ACCOUNT_FOUND);
        }
        // Logic
        $secret            = Token::rand_str(4);
        $password_add_salt = md5($password . $secret);
        $params            = [
            'secret'         => $secret, // 密码 - 盐值，每次生成密码时会重置
            'password'       => $password_add_salt, // 密码加盐后
            'email'          => $email, // 邮箱号只能对应一个账号
            'user_pic'       => $user_pic, // 用户头像地址
            'truename'       => $truename, // 用户真实姓名
            'remember_token' => '-', // 如果一个账号只能登录一次，则每次登录，会删掉上一次记录的登录信息
            'status'         => Admin::STATUS_NORMAL_USER, // 用户状态
        ];
        $result = Admin::create($params);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public static function auth_admin_logs(&$params)
    {
        $result = AdminLoginLog::where('admin_id', $params['admin_id'] ?? 0)
            ->orderBy('id', 'desc')
            ->paginate(self::PAGE_SIZE);
        $result->appends($params);
        return $result;
    }

    // --- 权限规则 模块

    /**
     * 权限规则一览
     * @return void
     */
    public static function auth_rule_show()
    {
        self::check_super();
        $result['info'] = DB::select('
            Select `id`, `name` as rule, `title`,`status`
            From `hlz_auth_rule`
            Order By `title` Asc
        ');
        return $result;
    }

    public static function auth_rule_add($title, $rule)
    {
        self::check_super();
        // 防重复
        $_find = DB::select('
            Select `title`
            From `hlz_auth_rule`
            Where `name`=?
        ', [$rule]);
        if (count($_find)) {
            $msg = '数据已存在，其名为：' . $_find[0]->title;
            throw new \ApiException($msg);
        }
        DB::insert('
            Insert into `hlz_auth_rule`
            (name,title)
            Values(?,?)
        ', [$rule, $title]);
        $id = DB::select('
            Select `id`
            From `hlz_auth_rule`
            Where `name`=?
        ', [$rule]);

        $data           = [];
        $data['status'] = true;
        $data['id']     = $id[0]->id;
        return $data;
    }

    public static function auth_rule_del($id)
    {
        self::check_super();
        $result = DB::update('
            Delete From `hlz_auth_rule`
            Where id = ?
        ', [$id]);
    }

    public static function auth_rule_status($id, $status)
    {
        self::check_super();
        $result = DB::update('
            Update `hlz_auth_rule`
            Set `status` = ?
            Where `id` = ?
        ', [$status, $id]);
    }

    // --- 管理组 模块

    public static function auth_group_add($title, $rules)
    {
        // 防重复
        $find = DB::select('
            Select `id`
            From `hlz_auth_group`
            Where `title`=?
        ', [$title]);
        if (count($find)) {
            $msg = '该组已存在';
            throw new \ApiException($msg);
        }
        //创建
        $result = DB::update('
            Insert into `hlz_auth_group`
            (title,rules)
            Values(?,?)
        ', [$title, $rules]);
    }

    public static function auth_group_modify($group_id, $value, $option)
    {
        switch (intval($option)) {
            case 1:
                $field = 'status';
                break;
            case 2:
                $field = 'title';
                break;
            case 3:
                $field = 'rules';
                break;

            default:
                throw new \ApiException("option 值错误");

                break;
        }
        // 更新
        $result = DB::update('
            Update `hlz_auth_group`
            Set `' . $field . '` = ?
            Where `id` = ?
        ', [$value, $group_id]);
    }

    public static function auth_group_del($group_id)
    {
        // 删除属于该管理组的群体
        DB::delete('
            Delete From `hlz_auth_group_access`
            Where group_id = ?
        ', [$group_id]);
        // 删除该管理组
        DB::delete('
            Delete From `hlz_auth_group`
            Where id = ?
        ', [$group_id]);
    }

    public static function auth_group_list()
    {
        $result['info'] = DB::select('
            Select id, title, status, rules
            From `hlz_auth_group`
            Order by id
        ', []);
        return $result;
    }

    public static function auth_one_group_rule($id)
    {
        $rules = DB::select('
            Select `rules`
            From `hlz_auth_group`
            Where `id` =?
        ', [$id]);

        $rule_str = '';
        if (count($rules)) {
            $rule_str = $rules[0]->rules;
        }
        $result['info'] = DB::select('
                Select `id`, `title`
                From `hlz_auth_rule`
                Where `id` in (' . $rule_str . ')
            ', []);
        return $result;
    }

}
