(function (jq, window, undefined) {
    'use strict';

    function Comment() {}
    // @action：修改状态、删除
    Comment.prototype.comment_change = function () {
        $(".comment_change").on("click", function () {
            var dom_this = this;
            var _form = {};
            var update_field = dom_this.parentNode.dataset.field;
            var update_value = dom_this.dataset.val;
            _form.id = dom_this.parentNode.dataset.comment_id;
            _form[update_field] = update_value;

            var init = {
                "title": "确认要设置 TA 的状态吗",
                "api_url": admin_api('user', 'comments_update'),
                "data": _form,
                "res_text": "更新成功",
            };
            if(update_field == 'is_deleted') {
                init.title = "确认要删除 TA 吗";
                init.res_text = "删除成功";
            }
            confirm_ajax(init);
        });
    };


    // @action:初始化日期插件
    Comment.prototype.comment_date_plugin = function () {
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
    };


    // @action：初始化
    Comment.prototype.initial = function () {
        this.comment_change();
        this.comment_date_plugin();
    };

    var comment = new Comment();
    comment.initial();



})(jQuery, window);