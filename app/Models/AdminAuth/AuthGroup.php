<?php

namespace App\Models\AdminAuth;

use Illuminate\Database\Eloquent\Model;

class AuthGroup extends Model
{
    /**
     * 对应表
     */
    protected $table = 'hlz_auth_group';

    /**
     * 填充字段
     */
    protected $fillable = [
        'title', // 密分组名称
        'status', // 状态
        'rules', // 分组拥有的所有的权限规则
    ];

    // 状态
    const STATUS_VAILD   = 1; // 可用
    const STATUS_INVAILD = 0; // 不可用

}
