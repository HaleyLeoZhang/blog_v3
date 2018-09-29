// - 时间选择器
// --- 开始时间
laydate.render({
    elem: '#time_start',
    type: 'datetime'
});
// --- 结束时间
laydate.render({
    elem: '#time_end',
    type: 'datetime'
});
// 背景设置
// - 操作按钮
(function (jq, window, undefined) {
    'use strict';
    function Article() {
        this.article_id = 0; // 文章ID
    }
    var article = new Article();
    // @Config 获取文章ID
    Article.prototype.set_article_id = function (trigger_dom) {
        var _this = this;
        _this.article_id = trigger_dom.parentNode.dataset.article_id;
        console.log(`文章ID初始化成功 => ${_this.article_id}`);
    };
    // @Action 查看
    Article.prototype.look_through = function () {
        var _this = this;
        window.open(`/article/${_this.article_id}.html`);
    };
    // @Action 修改
    Article.prototype.article_edit = function () {
        var _this = this;
        window.open(`/admin/article/detail_edit_view?id=${_this.article_id}`);
    };
    // @Action 删除
    Article.prototype.article_del = function () {
        var _this = this;
        var init = {
            "title": "你真的要删除吗",
            "api_url": admin_api('article', 'detail_del'),
            "data":{
                "id": _this.article_id
            },
            "res_text": "删除成功",
        };
        confirm_ajax(init);
    };
    // @Action 上线 - TODO
    Article.prototype.article_online = function () {
        var _this = this;
        var init = {
            "title": "确认上线这篇文章吗？",
            "api_url": admin_api('article', 'article_check_line'),
            "data":{
                "id": _this.article_id
            },
            "res_text": "上线成功",
        };
        confirm_ajax(init);
    };
    // @Action 下线 - TODO
    Article.prototype.article_offline = function () {
        var _this = this;
        var init = {
            "title": "确认下线这篇文章吗？",
            "api_url": admin_api('article', 'article_check_line'),
            "data":{
                "id": _this.article_id
            },
            "res_text": "下线成功",
        };
        confirm_ajax(init);
    };
    // @Action 跳转创建页面
    Article.prototype.article_create = function () {
        window.open( admin_api('article', 'detail_create_view') );
    };
    // --- 监听 --- 
    jq(".look_through").on("click", function(){
        article.set_article_id(this);
        article.look_through();
    });
    jq(".article_edit").on("click", function(){
        article.set_article_id(this);
        article.article_edit();
    });
    jq(".article_del").on("click", function(){
        article.set_article_id(this);
        article.article_del();
    });
    jq(".article_online").on("click", function(){
        article.set_article_id(this);
        article.article_online();
    });
    jq(".article_offline").on("click", function(){
        article.set_article_id(this);
        article.article_offline();
    });
    jq(".article_create").on("click", function(){
        article.article_create();
    });


})(jQuery, window);