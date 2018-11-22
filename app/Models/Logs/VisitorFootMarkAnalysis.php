<?php
namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;

// 用户访问足迹分析

class VisitorFootMarkAnalysis extends Model
{
    protected $table      = 'visitor_foot_mark_analysis';
    protected $connection = 'yth_blog_ext';

    protected $fillable = [
        'ip', // 访客IP
        'location', // 依据IP，查询出来的地理信息
        'device_type', // 设备类型：-2->没有相关信息、-1->其他、0->蜘蛛、1->移动端、2->PC
        'device_name', // 设备详细名称
        'referer', // 来源站点
        'target', // 访问地址
        'created_at', // 创建时间（与访客足迹的采集时间保持一致）
    ];

    /**
     * 设备类型
     */
    const DEVICE_TYPE_UNKNOW = -2;
    const DEVICE_TYPE_OTHERS = -1;
    const DEVICE_TYPE_SPIDER = 0;
    const DEVICE_TYPE_MOBILE = 1;
    const DEVICE_TYPE_PC = 2;
}
