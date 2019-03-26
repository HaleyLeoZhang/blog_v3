<?php

namespace App\Models\AdminAuth;

use Illuminate\Database\Eloquent\Model;

class AuthRule extends Model
{
    /**
     * 对应表
     */
    protected $table = 'hlz_auth_rule';

    /**
     * 填充字段
     */
    protected $fillable = [
        'name', // 规则昵称
        'title', // 具体规则
        'type', // 默认，1
        'status', // 可用状态：0->不可用，1->可用
        'condition', // 额外条件
    ];

}