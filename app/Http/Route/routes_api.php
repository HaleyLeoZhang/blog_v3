<?php
// ----------------------------------------------------------------------
// 前端接口
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

Route::Group(['prefix' => 'api', 'namespace' => 'Api', 'middleware' => ['api']], function () {

    // - 滑动验证码
    Route::Group(['prefix' => 'slide_verify'], function () {
        Route::get('init', ['uses' => 'SlideVerifyController@init']);
        Route::get('captchar', ['uses' => 'SlideVerifyController@captchar']);
        Route::post('check', ['uses' => 'SlideVerifyController@check']);
        Route::post('demo_rsa', ['uses' => 'SlideVerifyController@demo_rsa']);
    });

    // - 微信
    Route::Group(['prefix' => 'wechat'], function () {
        // Route::any('/', 'WechatController@check_signature'); // 验证前，路由指向这个方法
        Route::any('/', 'WechatController@entrance'); // 验证后，用于回复用户
    });

    // - 游客访问足迹
    Route::Group(['prefix' => 'behaviour'], function () {
        Route::post('foot_mark', 'BehaviourController@foot_mark');
    });

    // - 评论
    Route::Group(['prefix' => 'comment'], function () {
        Route::get('info', 'CommentController@info');
    });


    // - 通用接口
    Route::Group(['prefix' => 'general'], function () {
        Route::get('memorabilia_bg', 'GeneralController@memorabilia_bg');
        Route::get('express_delivery', 'GeneralController@express_delivery'); // 快递查询
    });

    // - 移动端 SPA
    Route::Group(['prefix' => 'spa'], function () {
        Route::get('category_list', 'SpaController@category_list');
        Route::get('article_list', 'SpaController@article_list');
        Route::get('article_detail', 'SpaController@article_detail');
    });

    // - 用户模块
    Route::Group(['middleware' => 'auth_user'], function () {
        Route::post('comment/reply_add', 'CommentController@reply_add');
    });


    // - 动漫图片
    Route::Group(['prefix' => 'comic'], function () {
        Route::get('pic_list', 'ComicController@pic_list'); // 图片列表
    });



});
