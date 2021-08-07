<?php
namespace App\Bussiness\Admin\Logic;

use App\Models\AdminAuth\Admin;
use App\Models\Blog\Comment;
use App\Models\Logs\UserHitLog;
use App\Models\User;
use App\Traits\UserHitLogTrait;

class UserAdminLogic
{
    use UserHitLogTrait;

    /**
     * @return array
     */
    public static function user_list($params)
    {
        extract($params);
        $chain = User::where('is_deleted', User::IS_DELETED_NO);
        if ($status != User::SHOW_ALL) {
            $chain = $chain->where('status', $status);
        }
        if ($time_start != '') {
            $chain = $chain->where('created_at', '>=', $time_start);
        }
        if ($time_end != '') {
            $chain = $chain->where('created_at', '<=', $time_end);
        }
        if ($user_type != User::SHOW_ALL) {
            $chain = $chain->where('type', '=', $user_type);
        }
        if ($user_name != '') {
            $vague = '%' . $user_name . '%';
            $chain = $chain->whereRaw('name like ? ', [$vague]);
        }
        $data = $chain
            ->orderBy('id', 'desc')
            ->paginate(\CommonService::END_USER_LIST_PAGE_SIZE);
        $data->appends($params);
        return $data;
    }

    /**
     * @return void
     */
    public static function user_list_handle($params)
    {
        extract($params);
        $object = User::where('id', $id)
            ->where('is_deleted', User::IS_DELETED_NO)
            ->first();
        if (is_null($object)) {
            throw new \ApiException("该用户不存在");
        } else {
            $object->update($params);
        }
    }

    /**
     * @return void
     */
    public static function hanld_bind_relation($params)
    {
        extract($params);
        $object = User::where('id', $id)
            ->where('is_deleted', User::IS_DELETED_NO)
            ->first();
        if (is_null($object)) {
            throw new \ApiException("该用户不存在");
        } else {
            $admin = \CommonService::$admin;
            // 其他管理员没有绑定过
            $other_admin = Admin::where('status', Admin::STATUS_NORMAL_USER)
                ->where('user_id', $id)
                ->where('id', '!=', $admin->id)
                ->first();
            if ($other_admin) {
                throw new \ApiException("已有其他管理员绑定过");
            }
            // - 查询是否有关联记录，如果没有则自动添加关联记录，否则抛出异常
            $bind               = [];
            $bind['user_id']    = $object->id; // 用户ID
            $bind['related_id'] = $admin->id; // 管理员ID
            $bind['type']       = UserHitLog::TYPE_BIND_ADMIN;
            $bind['remark']     = '与管理员绑定关系.action.创建关系';
            self::relation_user_create($bind);
            // - 解除之前的绑定关系
            $unbind               = [];
            $unbind['user_id']    = $admin->user_id; // 用户ID
            $unbind['related_id'] = $admin->id; // 管理员ID
            $unbind['type']       = UserHitLog::TYPE_BIND_ADMIN;
            $unbind['status']     = UserHitLog::STATUS_INVALID; // 用户ID
            $unbind['remark']     = '与管理员绑定关系.action.解除关系';
            self::relation_user_update($unbind);
            // - 创建关联关系
            $admin->user_id = $id;
            $admin->save();
        }
    }

    /**
     * @return array
     */
    public static function comments($params)
    {
        extract($params);
        $chain = Comment::selectRaw('
                comments.*,
                users.`name`,
                users.`pic`,
                articles.`title`
            ')
            ->leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->leftJoin('articles', 'articles.id', '=', 'comments.location')
            ->where('comments.is_deleted', Comment::IS_DELETED_NO);
        if ($status != Comment::SHOW_ALL) {
            $chain = $chain->where('comments.status', $status);
        }
        if ($time_start != '') {
            $chain = $chain->where('comments.created_at', '>=', $time_start);
        }
        if ($time_end != '') {
            $chain = $chain->where('comments.created_at', '<=', $time_end);
        }
        if ($vague != '') {
            $vague_word = '%' . $vague . '%'; // 数据量大于 2000 条后，调整为 coreseek 全文索引
            $chain      = $chain->whereRaw('comments.content like ? ', [$vague_word]);
        }
        $data = $chain
            ->orderBy('comments.id', 'desc')
            ->paginate(\CommonService::END_COMMENT_PAGE_SIZE);
        $data->appends($params);
        return $data;
    }

    /**
     * @return array
     */
    public static function comments_update($params)
    {
        extract($params);
        $object = Comment::where('id', $id)
            ->where('is_deleted', User::IS_DELETED_NO)
            ->first();
        if (is_null($object)) {
            throw new \ApiException("该评论不存在");
        } else {
            $object->update($params);
        }

    }

}
