<?php

namespace App\Models\AdminAuth;

use Illuminate\Database\Eloquent\Model;

// 管理员行为表

class AdminFooterMark extends Model
{

    protected $table = 'admin_footer_marks';
    protected $connection = 'yth_blog_ext';


    protected $fillable = [
        'admin_id',
        'email',
        'name',
        'route',
        'method',
        'params',
        'ip',
    ];



}
