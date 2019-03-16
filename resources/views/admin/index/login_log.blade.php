<!-- 继承页面 -->
@extends('admin.public.layout')
<!-- 页面标题 -->
@section('title') 登录日志 @endsection
<!-- 功能备注 -->
@section('mark') 自己的登录日志 @endsection
<!-- 内容 -->
@section('content')
<div class="row" style="position: relative;">
    <!-- begin col-6 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-5">
            <div class="panel-body">
                <div class="panel-body">
                    <form method="get" id="search_form">
                        <!-- 单行 -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1">
                                <label>开始时间</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="start_time" name="start_time" value="{{$params['start_time']??''}}">
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1">
                                <label>结束日期</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="end_time" name="end_time" value="{{$params['end_time']??''}}">
                                </div>
                            </div>
                            <div class="col-sm-1 col-sm-1">
                                <input type="submit" class="btn btn-info" value="搜索" />
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered table-hover" id="treeTable">
                    <thead>
                        <tr>
                            @foreach($ths as $key => $th)
                            <th>{{ $th }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tds as $td)
                        <tr>
                            @foreach($td as $key => $item)
                            <td>{{ $item }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p>共 {!! $render->total() !!} 条记录</p>
                {!! $render->render() !!}
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-6 -->
</div>
@endsection
<!-- js -->
@section('script')
<script src="{{ config('static_source_cdn.layer') }}"></script>
<script src="/static_pc/plugins/laydate/laydate.js"></script>
<script type="text/javascript">
// - 时间选择器
// --- 开始时间
laydate.render({
    elem: '#start_time',
    type: 'datetime'
});
// --- 结束时间
laydate.render({
    elem: '#end_time',
    type: 'datetime'
});
// 背景设置
// $(".content-wrapper").css({
//   "background-image":"url(http://img.cdn.hlzblog.top/17-10-22/14848187.jpg)", // 原图 /static_pc/admin/bg_bak.jpg
//   "background-attachment":"fixed",
//   "background-repeat":"no-repeat",
//   "background-size":"100% 100%"
// });
</script>
@endsection