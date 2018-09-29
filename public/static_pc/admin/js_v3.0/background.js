(function (jq, window, undefined) {
    'use strict';

    function Background() {}
    // @action：删除背景图
    Background.prototype.bg_delete = function (dom_this) {
        var init = {
            "title": "你真的要删除吗",
            "api_url": admin_api('article', 'background_del'),
            "data": {
                "id": dom_this.dataset.bg_id,
            },
            "res_text": "删除成功",
        };
        confirm_ajax(init);
    };
    // @action：修改链接
    Background.prototype.bg_change = function (dom_this) {
        layer.prompt({
            title: '请重新输入图片地址',
            formType: 3
        }, function (text_url, index) {
            var init = {
                "api_url": admin_api('article', 'background_edit'),
                "data": {
                    "url": text_url,
                    "id": dom_this.dataset.bg_id,
                },
                "res_text": "修改成功",
                "need_confirm": false,
            };
            confirm_ajax(init);
            layer.close(index);
        });
    };
    // @action：添加链接
    Background.prototype.bg_create = function (dom_this) {
        layer.prompt({
            title: '请输入图片链接',
            formType: 3
        }, function (text_url, index) {
            var init = {
                "api_url": admin_api('article', 'background_add'),
                "data": {
                    "url": text_url,
                },
                "res_text": "创建成功",
                "need_confirm": false,
            };
            confirm_ajax(init);
            layer.close(index);
        });
    };

    // bckground.initial();
    window.bckground = new Background();



})(jQuery, window);