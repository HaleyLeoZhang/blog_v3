<?php
namespace App\Bussiness\Article\Logic;

use ApiException;
use App\Helpers\Page;
use App\Models\Blog\Article;
use App\Models\Blog\ArticleCategory;
use App\Models\Blog\Comment;
use App\Bussiness\Log\LogBussiness;
use DB;
use LogService;

class ArticleLogic
{
    const RECOMMAND_PAGE_SIZE = 5; // 侧边推荐文章数量

    /**
     * 获取文章
     * @return object
     */
    public static function get_article($article_id)
    {
        $article_obj = Article::where('articles.id', $article_id)
            ->select('articles.*', 'b.title as cate_name', 'c.url as bg_url')
            ->rightJoin('article_categorys as b ', 'articles.cate_id', '=', 'b.id')
            ->rightJoin('backgrounds as c ', 'articles.bg_id', '=', 'c.id')
            ->where('articles.is_online', Article::IS_ONLINE_YES)
            ->where('articles.is_deleted', Article::IS_DELETED_NO)
            ->first();

        if (is_null($article_obj)) {
            $log = compact('article_id');
            LogService::debug('文章不存在.params', $log);
            throw new \ApiException("文章找不到了");
        }
        return $article_obj;
    }

    /**
     * 阅读量自增
     * @param $article_obj Article 单篇文章对象
     * @return void
     */
    public static function statistic_read($article_obj)
    {
        // [阅读量] + 1
        $article_obj->statistic = $article_obj->statistic + 1;
        $article_obj->save();
        // 阅读记录增加
        $location = $article_obj->id;
        $log      = compact('location');
        LogBussiness::visitor_read_log($log);
    }

    /**
     * [侧边] 所有分类以及数量
     * @return array
     */
    public static function get_cate_list()
    {
        // [侧边] 所有分类以及数量
        $cate_list = DB::select('
            SELECT
                a.`id`,
                a.`title`,
                count( b.id ) AS total
            FROM
                `article_categorys` AS a
                INNER JOIN `articles` AS b ON a.`id` = b.`cate_id`
            WHERE
                a.`is_deleted` = ? AND b.`is_online` = ?
            GROUP BY
                b.`cate_id`
        ', [ArticleCategory::IS_DELETED_NO, Article::IS_ONLINE_YES]);
        return $cate_list;
    }

    /**
     * [统计评论] 主楼与楼中楼总数量
     * @param int $location 坐标位置
     * @return int
     */
    public static function get_comments_counter($location)
    {
        $comments_counter = Comment::where('location', $location)
            ->where('status', Comment::STATUS_NORMAL)
            ->where('is_deleted', Comment::IS_DELETED_NO)
            ->count();
        return $comments_counter;
    }

    /**
     * [推荐同类文]
     * @param int $cate_id 文章类型ID
     * @return array
     */
    public static function get_rand_recommand($cate_id)
    {
        // - 同类文章数统计
        $similar_counter = Article::where('is_deleted', Article::IS_DELETED_NO)
            ->where('is_online', Article::IS_ONLINE_YES)
            ->where('cate_id', $cate_id)
            ->count();
        // --- 计算可随机的总长度
        $count_page = ceil($similar_counter / self::RECOMMAND_PAGE_SIZE);
        // --- 随机找一页用于推荐
        $_GET['to_page'] = mt_rand(1, $count_page);
        $pagenation      = new Page('
            SELECT
                `id`,
                `title`
            FROM
                `articles`
            WHERE
                `cate_id` = ?
                AND `is_deleted` = ?
                AND `is_online` = ?
            ORDER BY
                `id` DESC
                LIMIT ?,?
        ', [$cate_id , Article::IS_DELETED_NO, Article::IS_ONLINE_YES]);
        $pagenation->page_size = self::RECOMMAND_PAGE_SIZE;
        $pagenation->is_render = Page::IS_RENDER_NO;

        $pagenation_info = $pagenation->get_result();
        $recommands      = $pagenation_info['info'];
        return $recommands;
    }

}
