<?php

namespace App\Jobs;

// ----------------------------------------------------------------------
// 访问足迹采集服务
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Helpers\Location;
use App\Repositories\Log\Logic\VisitorLogLogic;
use App\Models\Logs\VisitorFootMark;
use App\Models\Logs\VisitorLookLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LogService;

class AnalysisVisitorJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    /**
     * 队列名，常用启动命令如下
     * php artisan queue:listen --queue=队列名（多个，以逗号隔开） --tries=3 --delay=5 --timeout=120
     * 最好是通过 supervisor 去运行 并且保持 与 运行 nginx 的用户相同
     */
    const QUEUE_NAME = 'analysis_visitor_job';

    /**
     * 任务类型声明
     */
    const ACTION_LOCATION_ANALYSIS = 1; // 分析 IP、header，并存储数据

    protected $type;
    protected $object;

    /**
     * 数据注入
     * @param string $type 发送类型
     * @param string $json_str json字符串，默认为 null
     * @return void
     */
    public function __construct($type, $json_str = null)
    {
        $this->type   = $type;
        $this->object = json_decode($json_str);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $log = [
            'type'   => $this->type,
            'object' => $this->object,
        ];
        LogService::debug('AnalysisVisitorJob.execute', $log);
        switch ($this->type) {
            case self::ACTION_LOCATION_ANALYSIS:
                $ip         = $this->object->ip;
                $location   = $this->get_location();
                $header     = $this->analysis_header();
                $is_article = $this->is_article();
                $url        = $this->object->url;
                $data       = compact('ip', 'location', 'url', 'header');

                $foot_mark = VisitorFootMark::create($data);
                VisitorLogLogic::visitor_foot_analysis($foot_mark);
                
                $log = compact('ip', 'location', 'header', 'is_article');
                LogService::debug('AnalysisVisitorJob.done.log', $log);
                break;
            default:
                LogService::info('AnalysisVisitorJob.queue.empty');
                break;
        }
    }

    /**
     * 查询IP对应的地理信息
     * @return string
     */
    public function get_location()
    {
        $location_info = Location::get_location_info($this->object->ip);
        $location      = [];
        $locate[]      = $location_info['country'];
        $locate[]      = $location_info['area'];
        $locate[]      = $location_info['region'];
        $locate[]      = $location_info['city'];
        $locate[]      = $location_info['county'];
        $locate[]      = $location_info['isp'];
        $str           = implode(' ', $locate);
        $str           = trim($str);
        return $str;
    }

    /**
     * 分析地理信息
     * @return string
     */
    public function analysis_header()
    {
        $str = $this->object->header;
        return $str;
    }

    /**
     * 判断是否为文章访问
     * - 如果是则加入访问记录、看
     * @return bool
     */
    public function is_article()
    {
        if (preg_match('/article\/(\d+)\.html/i', $this->object->url, $matches)) {
            $article_id      = $matches[1];
            $log             = [];
            $log['location'] = $article_id;
            VisitorLookLog::create($log);
            return true;
        } else {
            return false;
        }
    }

}
