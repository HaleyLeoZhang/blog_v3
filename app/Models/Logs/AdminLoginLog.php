<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;
use App\Models\AdminAuth\Admin;

// 用户访问某些模块的日志

class AdminLoginLog extends Model
{
    protected $table      = 'admin_login_logs';
    protected $connection = 'yth_blog_ext';
    
    protected $fillable   = [
        'admin_id', // 用户ID
        'ip', // 此次登录的IP信息
        'location', // 依据IP，查询出来的地理信息
    ];

    public $truename;
    public $email;

    public function admin(){
        $admin = new Admin();
        $object= $admin
            ->select('truename', 'email')
            ->where('id', $this->admin_id)
            ->orderBy('id', 'desc')
            ->first();
        $this->truename = $object->truename ?? '-';
        $this->email = $object->email ?? '-';;
    }
}
