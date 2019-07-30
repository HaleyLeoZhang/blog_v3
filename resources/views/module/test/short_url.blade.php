<form>
    <h3>请输入你要变短的网址：</h3>
    <br><br>
    <input type="text" id="long_url" placeholder="长地址" size='80'><br><br>
    <input type="button" id="btn" value='生成短链接'><br><br>
    <br>
</form>
<h5>生成的短地址，如下</h5>
<input type="text" id="short_url" placeholder="生成后的短地址" size='80'>
<script src="{{ config('static_source_cdn.jquery') }}"></script>
<script src="{{ config('static_source_cdn.layer') }}"></script>
<script>
(function ($, window, undefined) {
    'use strict';

    function ShortUrl() {
        this.long_url = ''; // 用户输入的长地址
    }
    // 获取短地址
    ShortUrl.prototype.request_api = function () {
        var _this = this;
        $.ajax({
            "url": "/api/general/short_url",
            "type": "post",
            "data": {
                "long_url": _this.long_url,
            },
            "dataType": "json",
            "success": function (d) {
                if(d.code != 200) {
                    layer.alert(d.message);
                } else {
                    $("#short_url").val(d.data.short_url);
                    layer.msg('短地址已生成');
                }
            },
            "error": function () {
                layer.message('网络错误');
            }
        });
    };
    // 检测数据格式
    ShortUrl.prototype.check_input = function () {
        var _this = this;
        if(null === _this.long_url.match(/^http/)) {
            layer.alert("请输入以 http 开头的地址");
            return false;
        }
        return true;
    };
    // 监听按钮
    ShortUrl.prototype.listener_btn = function () {
        var _this = this;
        $("#btn").on("click", function () {
            _this.long_url = $("#long_url").val();
            if(_this.check_input()) {
                _this.request_api();
            }
        });
    };
    ShortUrl.prototype.run = function () {
        var _this = this;
        _this.listener_btn();
    };

    var short_url = new ShortUrl();
    short_url.run();

})(jQuery, window);
</script>