<?php
// ----------------------------------------------------------------------
// 前端视图
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

Route::Group(['namespace' => 'Common'], function () {
    // 检测用户登录情况
    Route::Group(['middleware' => 'check_user'], function () {
        // - 首页
        Route::get('/', ['uses' => 'IndexController@render']);
        // - 留言板
        Route::get('board', ['uses' => 'IndexController@board']);
        // - 文章详情
        Route::get('article/{article_id}.html', ['uses' => 'ArticleController@detail']);
        // - 大事记
        Route::get('memorabilia.html', ['uses' => 'GeneralController@memorabilia']);
    });

    // - websocket 聊天
    Route::Group(['prefix' => 'chat'], function () {
        Route::get('demo', 'ChatController@demo');
    });

    // - 第三方登录
    Route::Group(['prefix' => 'oauth2'], function () {
        // --- 跳转到登录地址
        Route::get('redirect', ['uses' => 'OAuth2Controller@redirect']);
        //--- 第三方回调
        Route::any('qq', ['uses' => 'OAuth2Controller@qq']);
        Route::any('sina', ['uses' => 'OAuth2Controller@sina']);
        Route::any('github', ['uses' => 'OAuth2Controller@github']);
        Route::any('wechat', ['uses' => 'OAuth2Controller@wechat']);
        //--- PC端 cookie、重定向到登录之前
        Route::get('set_cookie', ['uses' => 'OAuth2Controller@set_cookie']);
        Route::get('get_cookie', ['uses' => 'OAuth2Controller@get_cookie']);
        // ---注销
        Route::get('logout', ['uses' => 'OAuth2Controller@logout']);
    });



    // - 测试页面
    Route::Group(['prefix' => 'test'], function () {
        // - 滑动验证码，示例
        Route::get('slide_verify', ['uses' => 'TestController@slide_verify']);
        // - 快递查询，示例
        Route::get('express_delivery', ['uses' => 'TestController@express_delivery']);
    });


});
