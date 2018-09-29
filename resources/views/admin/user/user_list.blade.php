<!-- 继承页面 -->
@extends('admin.public.layout')
<!-- 页面标题 -->
@section('title') 用户概览 @endsection
<!-- 功能备注 -->
@section('mark') 目前支持 QQ、新浪 用户 @endsection
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
                                <label>帐号状态</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <select class="form-control" name="status">
                                        @foreach($user_status as $key => $value )
                                        <option value="{{$key}}" {{ $params['status'] == $key? 'selected': '' }} />
                                             {{ $value }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <div class="col-xs-1 col-sm-1">
                                <label>帐号类型</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <select class="form-control" name="user_type">
                                        @foreach($user_type as $key => $value )
                                        <option value="{{$key}}" {{ $params['user_type'] == $key? 'selected': '' }} />
                                             {{ $value }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-1 col-sm-1">
                                <label>用户昵称</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <input 
                                        type="text" class="form-control" placeholder="昵称模糊搜索" 
                                        id="user_name" name="user_name" 
                                        value="{{ $params['user_name'] }}">
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
                                接入平台
                            </th>
                            <th>
                                头像
                            </th>
                            <th>
                                昵称
                            </th>
                            <th>
                                状态
                            </th>
                            <th>
                                更新时间
                            </th>
                            <th>
                                创建时间
                            </th>
                            <th>
                                帐号状态设置
                            </th>
                            <th>
                                其他操作
                            </th>
                        </thead>
                        <tbody>
                            @foreach($render as $render_one)
                            <tr>
                                <td >
                                    {{ $render_one->id }}
                                </td>
                                <td >
                                    <img src="{{ $src_user_type[$render_one->type] }}" alt="接入平台logo"
                                        style="width:60px;height:60px; border-radius:30px;" 
                                    />
                                </td>
                                <td >
                                    <img src="{{ $render_one->pic }}" alt="用户头像"
                                        style="width:60px;height:60px; border-radius:30px;" 
                                    />
                                </td>
                                <td >
                                    {{ $render_one->name }}
                                </td>
                                <td >
                                    {{ $user_status[$render_one->status] }}
                                </td>
                                <td >
                                    {{ $render_one->updated_at }}
                                </td>

                                <td >
                                    {{ $render_one->created_at }}
                                </td>

                                <td data-user_list_id="{{ $render_one->id }}" data-field="status">
                                    <!-- 正常 -->
                                    @if( $render_one->status != \App\Models\User::STATUS_NORMAL_USER  )
                                    <button class="btn btn-default user_list_update" 
                                        data-val="{{ \App\Models\User::STATUS_NORMAL_USER }}" 
                                    >正常</button>
                                    @endif
                                    <!-- 锁定 -->
                                    @if( $render_one->status != \App\Models\User::STATUS_LOCK_USER  )
                                    <button class="btn btn-warning user_list_update" 
                                        data-val="{{ \App\Models\User::STATUS_LOCK_USER }}" 
                                    >锁定</button>
                                    @endif
                                    <!-- 注销 -->
                                    @if( $render_one->status != \App\Models\User::STATUS_DELETED_USER  )
                                    <button class="btn btn-danger user_list_update" 
                                        data-val="{{ \App\Models\User::STATUS_DELETED_USER }}" 
                                    >注销</button>
                                    @endif
                                </td>

                                <td data-user_list_id="{{ $render_one->id }}" data-field="is_deleted">
                                    <button class="btn btn-danger user_list_update" 
                                        data-val="{{ \App\Models\User::IS_DELETED_YES }}"
                                     >删除</button>
                                     @if( \CommonService::$admin->user_id != $render_one->id )
                                    <button class="btn btn-info hanld_bind_relation" >绑定关系</button>
                                     @endif
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
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script src="{{ cdn_host() }}/static_pc/plugins/laydate/laydate.js"></script>
<!-- 前端逻辑 -->
<script src="/static_pc/admin/js_v3.0/user_list.js"></script>
@endsection