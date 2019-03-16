<!-- 继承页面 -->
@extends('admin.public.layout')
<!-- 页面标题 -->
@section('title') 足迹分析 @endsection
<!-- 功能备注 -->
@section('mark') 前端js获取的访客足迹 @endsection
<!-- 内容 -->
@section('content')
<div class="row" style="position: relative;">
    <!-- begin col-6 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-5">
            <div class="panel-body">

                <div class="panel-body">
                    <form method="get" id="search_form"><!-- 单行 -->
                        
                        <!-- 单行 -->
                        <div class="row">

                            <div class="col-xs-1 col-sm-1">
                                <label>设备类型</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <select class="form-control" name="device_type">
                                        @foreach($device_type_text as $key => $value )
                                        <option value="{{$key}}" {{ $params['device_type'] == $key? 'selected': '' }} />
                                             {{ $value }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-xs-1 col-sm-1">
                                <label>访客IP</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <input 
                                        type="text" class="form-control" placeholder="昵称模糊搜索" 
                                        id="ip" name="ip" 
                                        value="{{ $params['ip'] }}">
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
                                    <input type="text" class="form-control" 
                                        id="time_start" name="time_start" 
                                        value="{{ $params['time_start'] }}"
                                    />
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1">
                                <label>结束日期</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" 
                                        id="time_end" name="time_end" 
                                        value="{{ $params['time_end'] }}"
                                    />
                                </div>
                            </div>

                            <div class="col-sm-1 col-sm-1">
                                <button type="submit" class="btn btn-info"
                                <span class="fa fa-search"></span>搜索
                            </button>
                            </div>

                        </div>

                    </form>
                </div>



                <div class="panel-body">

                    <table class="table table-bordered table-hover" id="treeTable">
                        <thead>
                            <th>
                                ID
                            </th>
                            <th>
                                访客IP
                            </th>
                            <th>
                                地理信息
                            </th>
                            <th>
                                设备名称
                            </th>
                            <th>
                                访问地址
                            </th>
                            <th>
                                来源地址
                            </th>
                            <th>
                                创建时间
                            </th>
                        </thead>
                        <tbody>
                            @foreach($render as $render_one)
                            <tr>
                                <td >
                                    {{ $render_one->id }}
                                </td>
                                <td >
                                    {{ $render_one->ip }}
                                </td>
                                <td >
                                    {{ $render_one->location }}
                                </td>
                                <td >
                                    {{ $render_one->device_name }}
                                </td>
                                <td style="width:280px;">
                                    {{ $render_one->target }}
                                </td>
                                <td style="width:280px;">
                                    {{ $render_one->referer }}
                                </td>
                                <td >
                                    {{ $render_one->created_at }}
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
<script src="{{ config('static_source_cdn.layer') }}"></script>
<script src="/static_pc/plugins/laydate/laydate.js"></script>
<!-- 前端逻辑 -->
<script src="/static_pc/admin/js_v3.0/visitor_analysis.js"></script>
@endsection