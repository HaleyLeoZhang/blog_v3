<?php
namespace App\Services\Auth;

// ----------------------------------------------------------------------
// 权限管理，基类封装
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use DB;

class BaseAuthService
{

    //默认配置
    protected $_config = array(
        'AUTH_ON'           => true, // 认证开关
        'AUTH_GROUP'        => 'hlz_auth_group', // 用户组数据表名
        'AUTH_GROUP_ACCESS' => 'hlz_auth_group_access', // 用户-用户组关系表
        'AUTH_RULE'         => 'hlz_auth_rule', // 权限规则表
        'AUTH_USER'         => 'admins', // 管理员信息表
    );

    /**
     * 构造函数
     */
    public function __construct()
    {
        if (config('hlz_auth')) {
            //可设置配置项 hlz_auth, 此配置项为数组。
            $this->_config = array_merge($this->_config, config('hlz_auth')); // 请先配置 config/hlz_auth.php 文件
        }
    }

    /**
     * 检查权限
     * @param name string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
     * @param uid  int           认证用户的id
     * @param string mode        执行check的模式
     * @param relation string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
     * @return boolean           通过验证返回true;失败返回false
     */
    public function check($name, $uid, $type = 1, $mode = 'url', $relation = 'or')
    {
        if (!$this->_config['AUTH_ON']) {
            return true;
        }
        // - 处理 restful

        //获取用户需要验证的所有有效规则列表
        $authList = $this->getAuthList($uid, $type);
        // \Log::info('权限列表', [$authList]);
        if (is_string($name)) {
            $name       = strtolower($name);
            $split_name = explode('/', $name);
            if (strpos($name, ',') !== false) {
                $name = explode(',', $name);
            } else {
                $name = array($name);
            }
        }
        $list = array(); //保存验证通过的规则名
        if ($mode == 'url') {
            $REQUEST = unserialize(strtolower(serialize($_REQUEST)));
        }
        foreach ($authList as $auth) {
            // // - 处理 restful，最好不要这种方式，解析对比时，会有攻击点
            // $auth       = strtolower($auth);
            // $split_rule = explode('/', $auth);
            // $query      = preg_replace('/^.+\?/U', '', $auth);
            // // --- 取差集
            // $diff_split = array_diff($split_rule, $split_name);
            // if (0 == count($diff_split)) {
            //     $list[] = $auth;
            //     return true;
            // } elseif ($mode == 'url' && $query != $auth) {
            //     parse_str($query, $param); //解析规则中的param
            //     $intersect = array_intersect_assoc($REQUEST, $param);
            //     $auth      = preg_replace('/\?.*$/U', '', $auth);
            //     //如果节点相符且url参数满足
            //     if (in_array($auth, $name) && $intersect == $param) {
            //         $list[] = $auth;
            //     }
            // } elseif (in_array($auth, $name)) {
            //     $list[] = $auth;
            // }

            $auth = strtolower($auth);
            if ($mode == 'url' && $query != $auth) {
                parse_str($query, $param); //解析规则中的param
                $intersect = array_intersect_assoc($REQUEST, $param);
                $auth      = preg_replace('/\?.*$/U', '', $auth);
                //如果节点相符且url参数满足
                if (in_array($auth, $name) && $intersect == $param) {
                    $list[] = $auth;
                }
            } elseif (in_array($auth, $name)) {
                $list[] = $auth;
            }
        }
        if ($relation == 'or' and !empty($list)) {
            return true;
        }
        $diff = array_diff($name, $list);
        if ($relation == 'and' and empty($diff)) {
            return true;
        }
        return false;
    }

    /**
     * 根据用户id获取用户组,返回值为数组
     * @param  uid int     用户id
     * @return array       用户所属的用户组 array(
     *                                         array('uid'=>'用户id','group_id'=>'用户组id','title'=>'用户组名称','rules'=>'用户组拥有的规则id,多个,号隔开'),
     *                                         ...)
     */
    public function getGroups($uid)
    {
        static $groups = array();
        if (isset($groups[$uid])) {
            return $groups[$uid];
        }

        $user_groups = DB::select("
            Select * From {$this->_config['AUTH_GROUP_ACCESS']} as a
            Inner Join {$this->_config['AUTH_GROUP']} as g
            On a.group_id = g.id
            Where  a.uid='{$uid}' and g.status='1'
        ");

        if (count($user_groups)) {
            $user_groups = json_decode(json_encode($user_groups), true);
        }

        $groups[$uid] = $user_groups ?: array();
        return $groups[$uid];
    }

    /**
     * 获得权限列表
     * @param integer $uid  用户id
     * @param integer $type
     */
    protected function getAuthList($uid, $type)
    {
        static $_authList = array(); //保存用户验证通过的权限列表
        $t                = implode(',', (array) $type);
        if (isset($_authList[$uid . $t])) {
            return $_authList[$uid . $t];
        }

        //读取用户所属用户组
        $groups = $this->getGroups($uid);
        $ids    = array(); //保存用户所属用户组设置的所有权限规则id
        foreach ($groups as $g) {
            $ids = array_merge($ids, explode(',', trim($g['rules'], ',')));
        }
        $ids = array_unique($ids);
        if (empty($ids)) {
            $_authList[$uid . $t] = array();
            return array();
        }

        //读取用户组所有权限规则
        $rules = DB::table($this->_config['AUTH_RULE'])
            ->whereIn('id', $ids)
            ->where('type', $type)
            ->where('status', 1)
            ->get();
        if (count($rules)) {
            $rules = json_decode(json_encode($rules), true);

        }
        //循环规则，判断结果。
        $authList = array(); //
        foreach ($rules as $rule) {
            if (!empty($rule['condition'])) {
                // 根据condition进行验证
                $user = $this->getUserInfo($uid); //获取用户信息,一维数组

                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $rule['condition']);
                // dump($command);//debug
                @(eval('$condition=(' . $command . ');'));
                if ($condition) {
                    $authList[] = strtolower($rule['name']);
                }
            } else {
                //只要存在就记录
                $authList[] = strtolower($rule['name']);
            }
        }
        $_authList[$uid . $t] = $authList;
        return array_unique($authList);
    }

    /**
     * 获得用户资料,根据自己的情况读取数据库
     */
    protected function getUserInfo($uid)
    {
        static $userinfo = array();
        if (!isset($userinfo[$uid])) {
            $userinfo[$uid] = DB::table($this->_config['AUTH_USER'])
                ->where('id', $uid)
                ->first();
            if ($userinfo[$uid]) {
                $userinfo[$uid]->toArray();
            } else {
                $userinfo[$uid] = [];
            }
        }
        return $userinfo[$uid];
    }

}


