<?php

namespace App\Console\Commands;

use App\Services\Search\ElasticService;
use Illuminate\Console\Command;
use LogService as Log;
use Exception;

class ElasticSearchCommond extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es {index_action?} {index_name?} {index_type?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '
        创建或者删除索引
    ';

    static $action_list = [
        'create',
        'delete',
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info(__CLASS__ . '.start');
        $index_action     = $this->argument('index_action');
        $this->index_name = $this->argument('index_name');
        $this->index_type = $this->argument('index_type');

        $this->validate_action($index_action);
        $func = 'index_' . $index_action;
        $this->$func();
        Log::info(__CLASS__ . '.end');
    }

    protected function validate_action($index_action)
    {
        if (!in_array($index_action, self::$action_list)) {
            throw new Exception('目前只允许的操作是: ' . implode('、', self::$action_list));
        }
    }

    public function index_create()
    {
        $params = [
            'index' => $this->index_name,
            'body'  => [
                'settings' => [
                    'number_of_shards'   => 1, // 分片数: 最大节点数=分片数*副本数+1
                    'number_of_replicas' => 1, // 副本数
                ],
            ],
        ];

        $response = ElasticService::get_client()->indices()->create($params);
        Log::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', [$response]);
    }

    public function index_delete()
    {
        $params = [
            'index' => $this->index_name,
        ];

        $response = ElasticService::get_client()->indices()->delete($params);
        Log::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', [$response]);
    }

}
