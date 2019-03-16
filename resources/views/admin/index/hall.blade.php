<!-- 继承页面 -->
@extends('admin.public.layout') 
<!-- 页面标题 -->
@section('title')
    首页
@endsection 


<!-- 功能备注 -->
@section('mark')
    站点基本信息
@endsection 

<!-- 内容 -->
@section('content')
        <div class="row" style="opacity: 0.5;">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">系统信息</h3>
                    </div>
                    <div class="box-body table-responsive" style="overflow-x: hidden;">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr>
                                        <td>服务器域名： {{ $system_info['hostName'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>PHP版本： {{ $system_info['phpVersion'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>服务器端信息：{{ $system_info['runOS'] }}/{{ $system_info['serverInfo'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>最大上传限制：{{ $system_info['maxUploadSize'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>最大执行时间：{{ $system_info['maxExecutionTime'] }} seconds</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">版权申明</h3>
                    </div>
                    <div class="box-body table-responsive" style="overflow-x: hidden;">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                    <tr>
                                        <td>版权所有：<a href="https://github.com/HaleyLeoZhang" target="_blank">https://github.com/HaleyLeoZhang</a></td>
                                    </tr>
                                    <tr>
                                        <td>法律声明：<a href="/Info/law.html" target="_blank">查看声明</a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection 
<!-- js -->
@section('script')
<script src="{{ config('static_source_cdn.layer') }}"></script>
<script src="{{ config('static_source_cdn.wang_editor_js') }}"></script>
<script type="text/javascript">
// 背景设置
$(".content-wrapper").css({
  "background-image":"url(http://img.cdn.hlzblog.top/17-10-22/14848187.jpg)", // 原图 /static_pc/admin/bg_bak.jpg
  "background-attachment":"fixed",
  "background-repeat":"no-repeat",
  "background-size":"100% 100%"
});

</script>
@endsection