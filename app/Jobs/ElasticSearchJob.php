<?php

namespace App\Jobs;

// ----------------------------------------------------------------------
// 更新 ElasticSearch 中的索引
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Services\Search\ElasticService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LogService as Log;

class ElasticSearchJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    /**
     * 队列名，常用启动命令如下
     * php artisan queue:listen --queue=队列名（多个，以逗号隔开） --tries=3 --delay=5 --timeout=120
     * 最好是通过 supervisor 去运行 并且保持 与 运行 nginx 的用户相同
     */
    const QUEUE_NAME = 'elastic_search_job';

    /**
     * 任务类型声明
     */
    protected $data_action;
    protected $article_id;

    /**
     * @var 数据操作
     */
    const DATA_CREATE = 'create';
    const DATA_UPDATE = 'update';
    const DATA_DELETE = 'delete';

    /**
     * 数据注入
     * @param string $json_str
     * @return void
     */
    public function __construct($json_string)
    {
        $data = json_decode($json_string, true);

        $this->data_action = $data['data_action'];
        $this->index_name  = $data['index_name'];
        $this->index_type  = $data['index_type'];
        $this->body        = $data['body'] ?? null; // 待索引数据,普通数组数据就行了
        $this->id          = $data['id'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $log = [
            'data_action' => $this->data_action,
            'index_name'  => $this->index_name,
            'index_type'  => $this->index_type,
            'body'        => $this->body,
            'id'          => $this->id,
        ];
        Log::debug(self::QUEUE_NAME . '.execute', $log);
        $func = 'action_' . $this->data_action;
        $this->$func();
    }

    /**
     * 创建es中的对应索引
     * @return void
     */
    public function action_create()
    {
        if ($this->check_index_exists()) {
            Log::debug(__CLASS__ . '.' . __FUNCTION__ . '.该数据已创建过');
            return;
        }
        $params = [
            'index' => $this->index_name,
            'type'  => $this->index_type,
            'id'    => $this->id,
            'body'  => $this->body,
        ];
        $response = ElasticService::get_client()->index($params);
        Log::debug(__CLASS__ . '.' . __FUNCTION__ . '.', [$response]);
    }

    /**
     * 更新es中的对应索引
     * @return void
     */
    public function action_update()
    {
        $params = [
            'index' => $this->index_name,
            'type'  => $this->index_type,
            'id'    => $this->id,
            'body'  => $this->body,
        ];

        $response = ElasticService::get_client()->update($params);
        Log::debug(__CLASS__ . '.' . __FUNCTION__ . '.', [$response]);
    }

    public function action_delete()
    {
        $params = [
            'index' => $this->index_name,
            'type'  => $this->index_type,
            'id'    => $this->id,
        ];

        $response = ElasticService::get_client()->delete($params);
        Log::debug(__CLASS__ . '.' . __FUNCTION__ . '.', [$response]);
    }

    /**
     * @return bool
     * - true 存在
     * - false 不存在
     */
    protected function check_index_exists()
    {
        $params = [
            'index' => $this->index_name,
            'type'  => $this->index_type,
            'id'    => $this->id,
        ];

        $response = ElasticService::get_client()->exists($params);
        Log::debug(__CLASS__ . '.' . __FUNCTION__ . '.', [$response]);
        return $response;
    }

}
