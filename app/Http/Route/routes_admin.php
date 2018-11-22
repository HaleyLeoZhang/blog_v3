<?php
// ----------------------------------------------------------------------
// 后台服务
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

Route::Group(['prefix' => 'admin'], function () {

    // 管理员 登陆、注销、谷歌验证码
    Route::Group(['namespace' => 'Auth'], function () {
        Route::get('login', ['uses' => 'AccountController@login']);
        Route::post('login_slide_verify', ['uses' => 'AccountController@login_slide_verify']);
        Route::post('login_google', ['uses' => 'AccountController@login_google']);
        Route::get('set_cookie', ['uses' => 'AccountController@set_cookie']);
        Route::get('get_cookie', ['uses' => 'AccountController@get_cookie']);
        Route::get('logout', ['uses' => 'AccountController@logout']);
        // - 管理员首次登录：绑定谷歌验证码
        Route::any('google_captchar', 'AccountController@google_captchar');
    });

    // 权限 -- 开始
    Route::Group(['middleware' => ['auth_admin']], function () {
        // - 权限配置模块 - 不需要配置规则，只允许超级管理员操作
        Route::Group(['namespace' => 'Auth'], function () {
            // - API
            Route::post('change_user', 'AuthApiController@change_user');
            Route::post('change_user_status', 'AuthApiController@change_user_status');

            Route::any('auth_rule_show', 'AuthApiController@auth_rule_show');
            Route::any('auth_rule_add', 'AuthApiController@auth_rule_add');
            Route::any('auth_rule_del', 'AuthApiController@auth_rule_del');
            Route::any('auth_rule_status', 'AuthApiController@auth_rule_status');

            Route::post('auth_group_add', 'AuthApiController@auth_group_add');
            Route::post('auth_group_modify', 'AuthApiController@auth_group_modify');
            Route::post('auth_group_del', 'AuthApiController@auth_group_del');
            Route::post('auth_group_list', 'AuthApiController@auth_group_list');
            Route::post('auth_one_group_rule', 'AuthApiController@auth_one_group_rule');

            Route::post('group_list', 'AuthApiController@group_list');
            Route::post('group_edit', 'AuthApiController@group_edit');

            Route::post('admin_user_show', 'AuthApiController@admin_user_show');
            Route::post('admin_user_status', 'AuthApiController@admin_user_status');
            Route::post('admin_user_del', 'AuthApiController@admin_user_del');

            Route::post('auth_find_admin', 'AuthApiController@find_account');
            Route::post('auth_user_register', 'AuthApiController@auth_user_register');

            // - View
            Route::get('auth_human', ['uses' => 'AuthViewController@auth_human']);
            Route::get('auth_rule', ['uses' => 'AuthViewController@auth_rule']);
            Route::get('auth_group', ['uses' => 'AuthViewController@auth_group']);
            Route::get('auth_admin_logs', ['uses' => 'AuthViewController@auth_admin_logs']);

        });
        // - 权限配置模块 - 结束

        Route::Group(['namespace' => 'Admin'], function () {
            // - 首页
            Route::Group(['namespace' => 'Index'], function () {
                Route::get('hall', ['uses' => 'ViewController@hall']); // 默认首页
                Route::get('login_log', ['uses' => 'ViewController@login_log']); // 登录日志
                Route::get('self_info', ['uses' => 'ViewController@self_info']); // 修改个人帐号信息
                Route::post('password_edit', ['uses' => 'ApiController@user_password_edit']); // 修改密码
            });

            // - 博文
            Route::Group(['prefix' => 'article', 'namespace' => 'Article'], function () {
                // - 分类
                Route::get('category', ['uses' => 'ViewController@category']);
                Route::get('category_info', ['uses' => 'ApiController@category_info']);
                Route::post('category_del', ['uses' => 'ApiController@category_del']);
                Route::post('category_edit', ['uses' => 'ApiController@category_edit']);
                Route::post('category_add', ['uses' => 'ApiController@category_add']);
                // - 文章
                Route::get('detail', ['uses' => 'ViewController@detail']);
                Route::post('detail_create', ['uses' => 'ApiController@detail_create']);
                Route::get('detail_info', ['uses' => 'ApiController@detail_info']);
                Route::get('detail_search', ['uses' => 'ApiController@detail_search']);
                Route::post('detail_edit', ['uses' => 'ApiController@detail_edit']);
                Route::get('detail_edit_view', ['uses' => 'ViewController@detail_edit_view']);
                Route::get('detail_create_view', ['uses' => 'ViewController@detail_create_view']);

                Route::post('detail_del', ['uses' => 'ApiController@detail_del']);
                Route::post('article_check_line', ['uses' => 'ApiController@article_check_line']);

                // - 背景图
                Route::get('background', ['uses' => 'ViewController@background']);
                Route::post('background_add', ['uses' => 'ApiController@background_add']);
                Route::get('background_info', ['uses' => 'ApiController@background_info']);
                Route::post('background_edit', ['uses' => 'ApiController@background_edit']);
                Route::post('background_del', ['uses' => 'ApiController@background_del']);

            });

            // - 用户
            Route::Group(['prefix' => 'user', 'namespace' => 'User'], function () {
                // - 用户概览
                Route::get('user_list', ['uses' => 'ViewController@user_list']);
                Route::post('user_list_handle', ['uses' => 'ApiController@user_list_handle']);
                Route::post('hanld_bind_relation', ['uses' => 'ApiController@hanld_bind_relation']);
                // - 评论类别
                Route::get('comments', ['uses' => 'ViewController@comments']);
                Route::post('comments_update', ['uses' => 'ApiController@comments_update']);
            });

            // - 访客
            Route::Group(['prefix' => 'visitor', 'namespace' => 'Visitor'], function () {
                // - 访客解析结果
                Route::get('foot_mark_analysis', ['uses' => 'ViewController@foot_mark_analysis']);
            });

            // - 公共配置
            Route::Group(['prefix' => 'common', 'namespace' => 'Common'], function () {
                Route::get('friend_link', ['uses' => 'ViewController@friend_link']);
                Route::post('friend_link_update', ['uses' => 'ApiController@friend_link_update']);
            });

            // - 图片上传
            Route::Group(['prefix' => 'upload', 'namespace' => 'Upload'], function () {
                Route::post('markdown', ['uses' => 'ApiController@markdown']);
                Route::post('editor', ['uses' => 'ApiController@editor']);
            });
        });
    }); // 权限 -- 结束
});
