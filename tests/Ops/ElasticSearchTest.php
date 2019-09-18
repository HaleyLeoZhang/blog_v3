<?php
namespace tests\Ops;

use App\Models\Blog\Article;
use App\Services\Search\ElasticService;
use LogService as Log;

class ElasticSearchTest extends \TestCase
{
    static $index_name = 'yth_blog_avatar_articles';
    static $index_type = 'info';
    static $id         = '1';

    public function test_data_create()
    {
        $params = [
            'index' => self::$index_name,
            'type'  => self::$index_type,
            'id'    => self::$id,
            'body'  => [
                'name'  => '戒魔人-测试',
                'intro' => '戒魔人男主周小安,当初他捡了一枚戒指...',
            ],
        ];
        $response = ElasticService::get_client()->index($params);
        Log::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', [$response]);
    }

    public function data_udpate()
    {
        $params = [
            'index' => self::$index_name,
            'type'  => self::$index_type,
            'id'    => '2',
            'body'  => [
                'name'  => '戒魔人-测试2',
                'intro' => '戒魔人男主周小安,当初他捡了一枚戒指...',
            ],
        ];
        $response = ElasticService::get_client()->index($params);
        Log::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', [$response]);
    }

    public function data_get_by_id()
    {
        $params = [
            'index' => self::$index_name,
            'type'  => self::$index_type,
            'id'    => '1',
        ];
        $response = ElasticService::get_client()->get($params);
        Log::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', [$response]);
    }

    public function data_search()
    {
        $params = [
            'index' => self::$index_name,
            'type'  => self::$index_type,
            'body'  => [
                'query' => [
                    'match' => [
                        'intro' => '周小安',
                    ],
                ],
            ],
        ];
        $response = ElasticService::get_client()->search($params);
        Log::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', [$response]);
    }

    public function index_create()
    {
        $params = [
            'index' => self::$index_name,
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
            'index' => self::$index_name,
        ];

        $response = ElasticService::get_client()->indices()->delete($params);
        Log::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', [$response]);
    }

    public function index_exists()
    {
        $params = [
            'index' => self::$index_name,
            'type'  => self::$index_type,
            'id'    => self::$id,
        ];

        $response = ElasticService::get_client()->exists($params);
        Log::debug(__CLASS__ . '.' . __FUNCTION__ . '.', [$response]);
    }
    public function test_data_create_batches()
    {
        Log::debug(__CLASS__ . '@' . __FUNCTION__ . '.start');
        Article::where('is_deleted', Article::IS_DELETED_NO)
            ->chunk(100, function ($articles) {
                foreach ($articles as $article) {
                    $params = [
                        'index' => Article::ES_INDEX_NAME,
                        'type'  => Article::ES_INDEX_TYPE,
                        'id'    => $article->id,
                        'body'  => [
                            'title'    => $article->title,
                            'descript' => $article->descript,
                            'text'     => $article->getPureText(),
                        ],
                    ];
                    $response = ElasticService::get_client()->index($params);
                    Log::debug(__CLASS__ . '@' . __FUNCTION__ . '.res', [$response]);
                }
            });
        Log::debug(__CLASS__ . '@' . __FUNCTION__ . '.end');
    }

}
