(function (jq, window, undefined) {
    'use strict';

    function SelfInfo() {}
    // @action：修改帐号密码
    SelfInfo.prototype.password_edit = function () {
        var _this = this;
        $(".sub_pwd_edit").on("click", function () {
            var password_ = $("#password").val();
            if( _this.fiter_password(password_) ){
                return;
            }
            var password_raw = encodeURIComponent(rsa_encode(password_));
            var init = {
                "title": "确认修改密码吗",
                "api_url": '/admin/password_edit',
                "data": {
                    "password": password_raw,
                },
                "res_text": "操作成功",
            };
            confirm_ajax(init);
        });
    };
    // @filter:检测密码长度，不得低于6位
    SelfInfo.prototype.fiter_password = function (password) {
        console.log('当前密码 ' + password);
        if( password.length < 6 ){
            layer.msg('密码长度不能小于6位！');
            return true;
        }
        return false;
    };

    // @action：初始化
    SelfInfo.prototype.initial = function () {
        this.password_edit();
    };

    window.self_info = new SelfInfo();
    self_info.initial();



})(jQuery, window);