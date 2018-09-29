<?php

namespace App\Traits;

use App\Models\Logs\UserHitLog;
use Log;

trait UserHitLogTrait
{
    /**
     * 用户访问或者操作某些模块的日志 - 查看
     * @params array   $user_id, $related_id ,$type
     * @return UserHitLog
     */
    public static function relation_user_exists($params)
    {
        extract($params);
        $object = UserHitLog::where('user_id', $user_id)
            ->where('related_id', $related_id)
            ->where('type', $type)
            ->where('status', UserHitLog::STATUS_VALID)
            ->orderBy('id', 'desc')
            ->first();
        return $object;
    }

    /**
     * 用户访问或者操作某些模块的日志 - 修改记录
     * @params array   $user_id, $related_id ,$type, $remark
     * @return bool
     * - false 未查询到相关记录 true 更新成功
     */
    public static function relation_user_update($params)
    {
        extract($params);
        $object = self::relation_user_exists($params);
        if (is_null($object)) {
            return false;
        } else {
            $object->update($params);
            return true;
        }
    }

    /**
     * 用户访问或者操作某些模块的日志 - 增加记录
     * @params array   $user_id,  $related_id ,$type, $remark
     * @return UserHitLog
     */
    public static function relation_user_create($params)
    {
        extract($params);
        $object = self::relation_user_exists($params);
        if (is_null($object)) {
            UserHitLog::create($params);
        } else {
            throw new \ApiException("记录已存在");
        }
    }

}
