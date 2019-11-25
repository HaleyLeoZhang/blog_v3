<?php
namespace tests\Bussiness;

use App\Bussiness\Article\ArticleBussiness;
use LogService;

class ArticleBussinessTest extends \TestCase
{

    public function test_detail()
    {
        $article_id = 26;
        $result     = ArticleBussiness::detail($article_id);
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', [$result]);
    }

}
