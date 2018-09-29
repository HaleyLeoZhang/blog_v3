<?php
namespace App\Repositories\Admin\Logic;

use App\Models\AdminAuth\Admin;
use App\Models\Blog\FriendLink;

class CommonModuleAdminLogic
{
    /**
     * @return array
     */
    public static function friend_link()
    {
        $data = FriendLink::where('is_deleted', FriendLink::IS_DELETED_NO)
            ->orderBy('weight', 'desc')
            ->orderBy('id', 'asc')
            ->get();
        return $data;
    }

    /**
     * @return void
     */
    public static function friend_link_update($params)
    {
        extract($params);
        if (isset($id)) {
            $object = FriendLink::where('id', $id)
                ->where('is_deleted', FriendLink::IS_DELETED_NO)
                ->first();
            if (is_null($object)) {
                throw new \ApiException("该友联不存在");
            } else {
                $object->update($params);
            }
        } else {
            FriendLink::create($params);
        }

    }
}
