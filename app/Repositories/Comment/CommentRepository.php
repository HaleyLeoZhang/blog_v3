<?php
namespace App\Repositories\Comment;

// use App\Repositories\Chat\Logic\PublicChatLogic; // - TODO
// use App\Repositories\Chat\Logic\PrivateChatLogic; // - TODO
use App\Repositories\Comment\Logic\CommentLogic;
use App\Helpers\Page;

// ----------------------------------------------------------------------
// 模块 - 评论
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class CommentRepository
{
    /**
     * 获取评论信息
     * @param int  parent_id 主楼ID，0>是已是主楼
     * @param int  location x<0表示其他位置,x==0表示留言板，x>0其他表示文章ID
     * @return array
     */
    public static function info($parent_id, $location)
    {
        $data = CommentLogic::info($parent_id, $location, Page::IS_RENDER_YES);
        return $data;
    }

    /**
     * 发起评论
     * @param array  $params   parent_id,content,location
     */
    public static function reply_add($params)
    {
        $data = CommentLogic::reply_add($params);
        return $data;
    }

}
