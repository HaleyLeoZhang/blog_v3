(function (jq, window, undefined) {
    'use strict';

    function PicBed() {} 
    // @listener: 删除
    PicBed.prototype.pic_bed_update = function(){
        $(".pic_bed_update").on("click", function () {
            var dom_this = this;
            var pic_bed_id = dom_this.parentNode.parentNode.dataset.id;
            var init = {
                "title": "确认删除吗",
                "api_url": admin_api('system', 'pic_bed_update'),
                "data": {
                    "id": pic_bed_id,
                    "is_deleted": 1,
                },
                "res_text": "删除成功",
            };
            confirm_ajax(init);
        });
    };
    // @action:初始化日期插件
    PicBed.prototype.user_list_date_plugin = function () {
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
    PicBed.prototype.initial = function () {
        this.user_list_date_plugin();
        this.pic_bed_update();
    };

    window.pic_bed = new PicBed();
    pic_bed.initial();

})(jQuery, window);