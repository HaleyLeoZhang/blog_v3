<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;

// 用户访问某些模块的日志

class UserLoginLog extends Model
{
    protected $table      = 'user_login_logs';
    protected $connection = 'yth_blog_ext';
    
    protected $fillable   = [
        'user_id', // 用户ID
        'ip', // 此次登录的IP信息
        'location', // 依据IP，查询出来的地理信息
    ];

}
