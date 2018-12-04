<?php
namespace tests\Repositories;

use App\Repositories\Article\ArticleRepository;
use LogService;

class ArticleRepositoryTest extends \TestCase
{

    public function test_detail()
    {
        $article_id = 26;
        $result     = ArticleRepository::detail($article_id);
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', [$result]);
    }

}
