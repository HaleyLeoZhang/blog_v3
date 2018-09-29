<?php

namespace App\Http\Controllers\Admin\Common;

/**
 * 公共模块
 */
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\CommonRepository;
use Illuminate\Http\Request;

class ViewController extends BaseController
{
    /**
     * 友情链接
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function friend_link(Request $request)
    {
        $render = CommonRepository::friend_link();
        $data        = compact('render');
        return view('admin/common/friend_link', $data);
    }

}
