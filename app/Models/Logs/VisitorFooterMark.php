<?php
namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;

// 用户访问足迹

class VisitorFooterMark extends Model
{
    protected $table = 'visitor_footer_marks';
    protected $connection = 'yth_blog_ext';

    protected $fillable = [
        'ip', // 访客IP
        'url', // 请求进来的链接地址
        'location', // 地理位置信息
        'header', // 请求头部信息，后期处理，会统计业务方向
    ];

}
