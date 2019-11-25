<?php
namespace App\Bussiness\Comment\Logic;

use App\Helpers\Page;
use App\Models\Blog\Comment;
use App\Models\User;
use App\Services\Tool\FilterService;

class CommentLogic
{
    /**
     * @return array
     */
    public static function info($parent_id, $location, $is_render)
    {
        $page = new Page('
            SELECT
                a.`id`,
                a.`created_at` as "time",
                a.`content`,
                b.`name`,
                b.`type`,
                b.`pic`
            FROM
                `comments` AS a
                INNER JOIN `users` AS b ON b.`id` = a.`user_id`
            WHERE
                a.`location` =? And a.`parent_id` = ? And a.`status` = ? AND a.`is_deleted` = ?
            ORDER BY
                a.`id` DESC
                LIMIT ?,?
        ', [$location, $parent_id, Comment::STATUS_NORMAL, Comment::IS_DELETED_NO]);
        if (!$parent_id) {
            $page->page_size = \CommonService::BLOG_COMMENT_CHILD_PAGE_SIZE;
        } else {
            $page->page_size = \CommonService::BLOG_COMMENT_PAGE_SIZE;
        }
        $page->is_render = $is_render;

        $data = $page->get_result();
        return $data;
    }

    /**
     * @return array
     */
    public static function reply_add($params):array
    {
        // - 用户如果不是正常状态，不允许评论
        if( \CommonService::$user->status != User::STATUS_NORMAL_USER ){
            throw new \ApiException("您当前没有评论权限");
        }
        $params['user_id'] = \CommonService::$user->id;
        // 'parent_id', 'content', 'location'
        // - XSS防护
        $params['content'] = FilterService::xss($params['content']);
        $model_read = Comment::create($params);
        $id         = $model_read->id;
        $back       = compact('id');
        return $back;
    }

}
