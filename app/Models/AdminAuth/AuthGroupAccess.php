<?php

namespace App\Models\AdminAuth;

use Illuminate\Database\Eloquent\Model;

class AuthGroupAccess extends Model
{
    /**
     * 对应表
     */
    protected $table = 'hlz_auth_group_access';

    /**
     * 填充字段
     */
    protected $fillable = [
        'uid', // 用户ID
        'group_id', // 用户组ID
    ];

}
