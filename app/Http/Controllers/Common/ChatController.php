<?php

namespace App\Http\Controllers\Common;

/**
 * 各种用户账号管理操作相关
 */
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class ChatController extends BaseController
{

    /**
     * 示例 - 仅供调试
     */
    public function demo(Request $request)
    {
        return view('module/chat/chat_platform');
    }

}
