<?php

namespace App\Http\Controllers\Admin\System;

/**
 * 公共模块
 */
use App\Http\Controllers\BaseController;
use App\Bussiness\Admin\SystemBussiness;
use App\Models\Logs\UploadLog;
use Illuminate\Http\Request;

class ViewController extends BaseController
{
    /**
     * 上传过的图片
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function pic_bed(Request $request)
    {
        $params = [];
        $params['type']       = $request->input('type', UploadLog::SHOW_ALL);
        $params['time_start'] = $request->input('time_start', '');
        $params['time_end']   = $request->input('time_end', '');
        \LogService::debug('params ' , $params);

        $render = SystemBussiness::pic_bed($params);
        $data   = compact(
            'render',
            'params'
        );
        return view('admin/system/pic_bed', $data);
    }

}
