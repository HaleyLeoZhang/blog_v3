(function (jq, window, undefined) {
    'use strict';

    function UserList() {}
    // @action：修改状态、删除
    UserList.prototype.user_list_change = function () {
        $(".user_list_update").on("click", function () {
            var dom_this = this;
            var _form = {};
            var update_field = dom_this.parentNode.dataset.field;
            var update_value = dom_this.dataset.val;
            _form.id = dom_this.parentNode.dataset.user_list_id;
            _form[update_field] = update_value;

            var init = {
                "title": "确认要设置 TA 的状态吗",
                "api_url": admin_api('user', 'user_list_handle'),
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

    // @action：修改状态、删除
    UserList.prototype.hanld_bind_relation = function () {
        $(".hanld_bind_relation").on("click", function () {
            var dom_this = this;
            var _form = {};
            _form.id = dom_this.parentNode.dataset.user_list_id;

            var init = {
                "title": "确认要用 TA 作为评论身份吗",
                "api_url": admin_api('user', 'hanld_bind_relation'),
                "data": _form,
                "res_text": "绑定成功",
            };
            confirm_ajax(init);
        });
    };

    // @action:初始化日期插件
    UserList.prototype.user_list_date_plugin = function () {
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
    UserList.prototype.initial = function () {
        this.user_list_change();
        this.hanld_bind_relation();
        this.user_list_date_plugin();
    };

    var user_list = new UserList();
    user_list.initial();



})(jQuery, window);