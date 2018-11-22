(function (jq, window, undefined) {
    'use strict';

    function VisitorAnalysis() {}
    // @action:初始化日期插件
    VisitorAnalysis.prototype.date_plugin = function () {
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
    VisitorAnalysis.prototype.initial = function () {
        this.date_plugin();
    };

    var user_list = new VisitorAnalysis();
    user_list.initial();



})(jQuery, window);