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

    var SWITCH_OFF = false;
    var SWITCH_ON = true;

    function ShortUrl() {
        this.long_url = ''; // 用户输入的长地址
        this.result_container_id = '#short_url';
    }
    // 获取短地址
    ShortUrl.prototype.request_api = function () {
        var _this = this;

        _this.loading(SWITCH_ON)
        $.ajax({
            "url": "/api/general/short_url",
            "type": "post",
            "data": {
                "long_url": _this.long_url,
                "channel": "third",
            },
            "dataType": "json",
            "success": function (d) {
                _this.loading(SWITCH_OFF);
                if(d.code != 200) {
                    layer.alert(d.message);
                } else {
                    $(_this.result_container_id).val(d.data.short_url);
                    layer.msg('短地址已生成');
                }
            },
            "error": function () {
                _this.loading(SWITCH_OFF);
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

    ShortUrl.prototype.loading = function (_switch) {
        var _this = this;
        if(SWITCH_ON === _switch) {
            _this.loading_index = layer.load(0, { shade: [0.5, '#fff'] }); // 加载层 开启
        } else {
            layer.close(_this.loading_index)
        }
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