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
    // @action：创建链接
    FriendLink.prototype.friend_link_create = function () {
        var _this = this;
        var _template = `
<div class="row" style="width: 420px;  margin-left:7px; margin-top:10px;">
    <div class="col-sm-12">
        <div class="input-group"> <span class="input-group-addon">名称</span>
            <input id="title_0" type="text" class="form-control " placeholder="请输入站点名"> </div>
    </div>
    <div class="col-sm-12" style="margin-top: 10px">
        <div class="input-group"> <span class="input-group-addon">链接</span>
            <input id="href_0" type="text" class="form-control" placeholder="请输入站点链接"> </div>
    </div>
    <div class="col-sm-12" style="margin-top: 10px">
        <div class="input-group"> <span class="input-group-addon">权重&nbsp;</span>
            <input id="weight_0" type="number" class="form-control" placeholder="请输入数字"> </div>
    </div>
    <div class="col-sm-12" style="margin-top: 10px;margin-bottom: 10px">
        <button class="btn btn-info" style="width: 100%;"
         onclick="friend_link.friend_link_create_request()">提交</button>
    </div>
</div>
        `;
        $(".friend_link_create").on("click", function () {
            //页面层-自定义
            layer.open({
                type: 1,
                title: false,
                closeBtn: 0,
                shadeClose: true,
                area:['450px', 'auto'],
                skin: 'layui-layer-lan',
                anim: 4, //动画类型
                content: _template,
            });
        });
    };

    // @action：发起创建请求
    FriendLink.prototype.friend_link_create_request = function () {
        var _data = {
                "title": $("#title_0").val(),
                "href": $("#href_0").val(),
                "weight": $("#weight_0").val(),
        };
        // - 数据校验
        if(  _data.title == ''){
            layer.msg('站点名不能为空');
            return ;
        }
        if(  _data.href == ''){
            layer.msg('链接不能为空');
            return ;
        }
        if(  _data.weight == ''){
            layer.msg('权重不能为空');
            return ;
        }
        var init = {
            "api_url": admin_api('common', 'friend_link_update'),
            "data": _data,
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