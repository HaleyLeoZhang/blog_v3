<?php
namespace App\Repositories\Admin\Logic;

use App\Models\Logs\UploadLog;

class SystemModuleAdminLogic
{
    /**
     * @return array
     */
    public static function pic_bed($params)
    {
        $chain = UploadLog::where('is_deleted', UploadLog::IS_DELETED_NO);
        if (UploadLog::SHOW_ALL != $params['type']) {
            $chain = $chain->where('type', $params['type']);
        }
        if ('' != $params['time_start']) {
            $chain = $chain->where('created_at', '>=', $params['time_start']);
        }
        if ('' != $params['time_end']) {
            $chain = $chain->where('created_at', '<=', $params['time_end']);
        }
        $render = $chain->orderBy('id', 'desc')
            ->paginate(\CommonService::END_PIC_BED_PAGE_SIZE);

        $render->appends($params);
        \LogService::info('params', $params);
        return $render;
    }

    /**
     * @return void
     */
    public static function pic_bed_update($params)
    {
        extract($params);
        if (isset($id)) {
            $object = UploadLog::where('id', $id)
                ->where('is_deleted', UploadLog::IS_DELETED_NO)
                ->first();
            if (is_null($object)) {
                throw new \ApiException("该图片不存在");
            } else {
                $object->update($params);
            }
        } else {
            // 上传逻辑
            throw new \ApiException("当前不支持图片上传");
        }
    }

}
