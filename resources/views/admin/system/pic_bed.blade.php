<!-- 继承页面 -->
@extends('admin.public.layout')
<!-- 页面标题 -->
@section('title') 图床 @endsection
<!-- 功能备注 -->
@section('mark') 依据权重从大到小排序 @endsection
<!-- 内容 -->
@section('content')
<div class="row" style="position: relative;">
    <!-- begin col-6 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-5">
            <div class="panel-body">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-1 col-sm-1">
                            <div class="form-group">
                                <button class="btn btn-default friend_link_create"><span class="fa fa-pencil-square-o"></span> 上传
                                </button>
                            </div>
                        </div>
                    </div>
                    <form>
                        <div class="row">
                            <div class="col-xs-1 col-sm-1">
                                <label>CDN类型</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <select class="form-control" name="type">
                                        @foreach(\App\Models\Logs\UploadLog::$end_system_type_text as $index => $cdn_name )
                                        <option value="{{$index}}" {{ $params[ 'type']== $index? 'selected': '' }} /> {{ $cdn_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- 单行 -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1">
                                <label>开始时间</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="time_start" name="time_start" value="{{ $params['time_start'] }}" />
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1">
                                <label>结束日期</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="time_end" name="time_end" value="{{ $params['time_end'] }}" />
                                </div>
                            </div>
                            <div class="col-sm-1 col-sm-1">
                                <button type="submit" class="btn btn-info" <span class="fa fa-search">
                                    </span>搜索
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        @foreach($render as $render_one)
                        <div class="col-xs-2 col-sm-2" style="margin-bottom:60px;">
                            <div class="input-group form-inline">
                                <!-- 图片展示 -->
                                <div class="row ">
                                    <a href="{{ $render_one->url }}" target="_blank">
                                        <img src="{{ $render_one->url }}" style="width:200px;height:150px;" alt="">
                                    </a>
                                </div>
                                <!-- 图片操作 -->
                                <div class="row">
                                    <form class="form-inline" role="form">
                                        <div class="form-group">
                                            <input class="form-control " value="{{ $render_one->url }}" />
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-danger" title="删除">
                                                <i class="fa fa-trash-o"></i>
                                        </div>
                                    </form>
                                </div>
                                <!-- 基础信息 -->
                                <div class="row" style="margin-top:10px;">
                                    <font color="#9f8fe0">
                                        CDN类型
                                    </font>
                                    <font color="#2b2b2b">
                                        {{ \App\Models\Logs\UploadLog::$type_text[$render_one->type] }}
                                    </font>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <font color="#dc4c4c">
                                        上传时间
                                    </font>
                                    <font color="#2b2b2b">
                                        {{ $render_one->created_at }}
                                    </font>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <p style="margin-bottom: 10px;">共 {!! $render->total() !!} 条记录
                    <br/>
                </p>
                {!! $render->render() !!}
            </div>
        </div>
    </div>
    <!-- end panel -->
</div>
<!-- end col-6 -->
</div>
@endsection
<!-- js -->
@section('script')
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script src="/static_pc/plugins/laydate/laydate.js"></script>
<!-- 前端逻辑 -->
<script>
(function (jq, window, undefined) {
    'use strict';

    function PicBed() {}
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
    };

    window.pic_bed = new PicBed();
    pic_bed.initial();

})(jQuery, window);
</script>
@endsection