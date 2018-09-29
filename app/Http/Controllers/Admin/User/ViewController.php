<?php

namespace App\Http\Controllers\Admin\User;

/**
 * 用户账号管理操作相关
 */
use App\Http\Controllers\BaseController;
use App\Models\Blog\Comment;
use App\Models\User;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\Request;

class ViewController extends BaseController
{
    /**
     * 用户概览
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function user_list(Request $request)
    {
        $params               = [];
        $params['status']     = $request->input('status', User::SHOW_ALL);
        $params['time_start'] = $request->input('time_start', '');
        $params['time_end']   = $request->input('time_end', '');
        $params['user_type']  = $request->input('user_type', User::SHOW_ALL);
        $params['user_name']  = $request->input('user_name', '');

        $render        = UserRepository::user_list($params);
        $user_status   = User::$message_status;
        $user_type     = User::$message_user_type;
        $src_user_type = User::$src_user_type;

        $data = compact(
            'params',
            'render',
            'user_status', 'user_type',
            'src_user_type'
        );
        return view('admin/user/user_list', $data);
    }

    /**
     * 评论列表
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function comments(Request $request)
    {
        $params               = [];
        $params['status']     = $request->input('status', Comment::SHOW_ALL);
        $params['time_start'] = $request->input('time_start', '');
        $params['time_end']   = $request->input('time_end', '');
        $params['vague']      = $request->input('vague', '');

        $render         = UserRepository::comments($params);
        $comment_status = Comment::$message_status;

        $data = compact(
            'params',
            'render',
            'comment_status'
        );
        return view('admin/user/comments', $data);
    }
}
