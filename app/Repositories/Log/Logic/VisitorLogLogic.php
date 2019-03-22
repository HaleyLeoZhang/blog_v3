<?php
namespace App\Repositories\Log\Logic;

use App\Helpers\Location;
use App\Models\Logs\VisitorFootMark;
use App\Models\Logs\VisitorFootMarkAnalysis;
use App\Models\Logs\VisitorLookLog;

class VisitorLogLogic
{

    /**
     * @return void
     */
    public static function analysis_visitor_foot_mark($params)
    {
        extract($params);

        // $ip, $header, $url

        $location_info = Location::get_location_info($ip);
        $locate        = [];
        $locate[]      = $location_info['country'];
        $locate[]      = $location_info['area'];
        $locate[]      = $location_info['region'];
        $locate[]      = $location_info['city'];
        $locate[]      = $location_info['county'];
        $locate[]      = $location_info['isp'];

        $location = implode(' ', $locate);
        $log      = compact('ip', 'location', 'url', 'header');
        VisitorFootMark::create($log);
        // 数据入队

    }

    /**
     * @return void
     */
    public static function visitor_read_log($params)
    {
        extract($params);
        $log             = [];
        $log['location'] = $location;
        VisitorLookLog::create($log);
    }

    /**
     * 访客足迹拆解
     * @param App\Models\Logs\VisitorFootMark $foot_mark
     * @return void
     */
    public static function visitor_foot_analysis($foot_mark)
    {
        $analysis = new VisitorFootMarkAnalysis();
        $header   = json_decode(preg_replace('/(\[|\])/', '', $foot_mark->header));
        // 获取访客IP
        $analysis->ip = $foot_mark->ip;
        // 访客地理位置
        $analysis->location = $foot_mark->location;
        // 设备类型：-2->没有相关信息、-1->其他、0->蜘蛛、1->移动端、2->PC
        $agent = 'user-agent';
        if (!$header->$agent) {
            \LogService::error('暂无agent信息');
            return;
        }
        switch (true) {
            case preg_match('/phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone/', $header->$agent, $match):
                $device_type = VisitorFootMarkAnalysis::DEVICE_TYPE_MOBILE;
                $device_name = $match[0];
                break;
            case preg_match('/Safari|MSIE|Firefox|Chrome|Maxthon|MetaSr|360SE/', $header->$agent, $match):
                $device_type = VisitorFootMarkAnalysis::DEVICE_TYPE_PC;
                $device_name = $match[0];
                break;
            case preg_match('/Baiduspider|360spider|Googlebot|bingbot/', $header->$agent, $match):
                $device_type = VisitorFootMarkAnalysis::DEVICE_TYPE_SPIDER;
                $device_name = $match[0];
                break;
            case '' != $header->$agent:
                $device_type = VisitorFootMarkAnalysis::DEVICE_TYPE_UNKNOW;
                $device_name = '';
                break;
            default:
                $device_type = VisitorFootMarkAnalysis::DEVICE_TYPE_OTHERS;
                $device_name = '';
                break;
        }
        $analysis->device_type = $device_type;
        // 设备详细名称
        $analysis->device_name = $device_name;
        // 来源站点
        $analysis->referer = $header->referer ?? '';
        // 访问地址
        $analysis->target = $foot_mark->url;
        // 创建时间（与访客足迹的采集时间保持一致）
        $analysis->created_at = $foot_mark->created_at;
        $analysis->save();
    }

    /**
     * 访客足迹查看
     * @param array $params
     * @return array
     */
    public static function visitor_foot_analysis_log($params)
    {
        extract($params); // device_type、ip、time_start, time_end
        $chain = VisitorFootMarkAnalysis::selectRaw('*');
        if (VisitorFootMarkAnalysis::SHOW_ALL != $device_type) {
            $chain = $chain->where('device_type', $device_type);
        }
        if ('' != $time_start) {
            $chain = $chain->where('created_at', '>=', $time_start);
        }
        if ('' != $time_end) {
            $chain = $chain->where('created_at', '<=', $time_end);
        }
        if ('' != $ip) {
            $chain = $chain->where('ip', $ip);
        }
        $page = $chain->orderBy('id', 'desc')
            ->paginate(\CommonService::END_VISITOR_ANALYSIS_PAGE_SIZE);
        $page->appends($params);
        return $page;
    }

}
