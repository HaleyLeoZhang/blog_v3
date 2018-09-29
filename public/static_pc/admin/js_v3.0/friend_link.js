(function (jq, window, undefined) {
    'use strict';

    function FriendLink() {}
    // @action：删除背景图
    FriendLink.prototype.friend_link_delete = function () {
        $(".friend_link_delete").on("click", function () {
            var dom_this = this;
            var init = {
                "title": "你真的要删除吗",
                "api_url": admin_api('common', 'friend_link_update'),
                "data": {
                    "id": dom_this.parentNode.dataset.friend_link_id,
                    "is_deleted": 1,
                },
                "res_text": "删除成功",
            };
            confirm_ajax(init);
        });
    };
    // @action：修改链接
    FriendLink.prototype.friend_link_change = function () {
        $(".friend_link_update").on("click", function () {
            var dom_this = this;
            var friend_link_id = dom_this.parentNode.dataset.friend_link_id;
            var init = {
                "title": "确认更新吗",
                "api_url": admin_api('common', 'friend_link_update'),
                "data": {
                    "id": friend_link_id,
                    "title": $("#title_" + friend_link_id).val(),
                    "href": $("#href_" + friend_link_id).val(),
                    "weight": $("#weight_" + friend_link_id).val(),
                },
                "res_text": "更新成功",
            };
            confirm_ajax(init);
        });
    };
    
    // @action：发起创建请求
    FriendLink.prototype.friend_link_create_request = function () {
        var init = {
            "api_url": admin_api('common', 'friend_link_update'),
            "data": {
                "title": $("#title_0").val(),
                "href": $("#href_0").val(),
                "weight": $("#weight_0").val(),
            },
            "res_text": "创建成功",
            "need_confirm": false,
        };
        console.log('init');
        console.log(init);
        confirm_ajax(init);
    };

    // @action：初始化
    FriendLink.prototype.initial = function () {
        this.friend_link_delete();
        this.friend_link_change();
        this.friend_link_create();
    };

    window.friend_link = new FriendLink();
    friend_link.initial();



})(jQuery, window);