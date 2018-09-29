<?php
namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;

// 用户访问足迹

class VisitorLookLog extends Model
{
    protected $table = 'visitor_look_logs';
    protected $connection = 'yth_blog_ext';

    protected $fillable = [
        'location', // x<0表示其他位置,x==0表示留言板，x>0其他表示文章ID
    ];

}
