<?php

namespace App\Http\Controllers\Admin\Visitor;

/**
 * 用户账号管理操作相关
 */
use App\Http\Controllers\BaseController;
use App\Models\Logs\VisitorFootMarkAnalysis;
use App\Repositories\Admin\VisitorRepository;
use Illuminate\Http\Request;

class ViewController extends BaseController
{
    /**
     * 用户概览
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function foot_mark_analysis(Request $request)
    {
        $params                = [];
        $params['device_type'] = $request->input('device_type', VisitorFootMarkAnalysis::SHOW_ALL);
        $params['ip']          = $request->input('ip', '');
        $params['time_start']  = $request->input('time_start', '');
        $params['time_end']    = $request->input('time_end', '');

        $render = VisitorRepository::foot_mark_analysis($params);

        $device_type_list = VisitorFootMarkAnalysis::$device_type_list;
        $device_type_text = VisitorFootMarkAnalysis::$device_type_text;

        $data = compact(
            'params',
            'render',
            'device_type_list',
            'device_type_text'
        );
        return view('admin/visitor/foot_mark_analysis', $data);
    }

}
