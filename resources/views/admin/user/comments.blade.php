<!-- 继承页面 -->
@extends('admin.public.layout')
<!-- 页面标题 -->
@section('title') 评论列表 @endsection
<!-- 功能备注 -->
@section('mark') 冻结用户后，其下的评论不可对外显示。 @endsection
<!-- 样式 -->
@section('css')
<style>
.user_pic{
    width:60px;height:60px; border-radius:30px;
}
.comment_content {
    font-size: 14px;
    font-family: 宋体,微软雅黑;
    color: #585757;
    line-height: 20px;
}
</style>
@endsection
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
                                <label>评论状态</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <select class="form-control" name="status">
                                        @foreach($comment_status as $key => $value )
                                        <option value="{{$key}}" {{ $params['status'] == $key? 'selected': '' }} />
                                             {{ $value }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-1 col-sm-1">
                                <label>评论内容</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <input 
                                        type="text" class="form-control" placeholder="内容模糊搜索" 
                                        id="vague" name="vague" 
                                        value="{{ $params['vague'] }}">
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
                                评论位置
                            </th>
                            <th>
                                头像
                            </th>
                            <th>
                                昵称
                            </th>
                            <th>
                                内容
                            </th>
                            <th>
                                更新时间
                            </th>
                            <th>
                                创建时间
                            </th>
                            <th>
                                状态
                            </th>
                            <th>
                                状态操作
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
                                <td style="width:200px;">
                                    {!! $render_one->get_title_src() !!}
                                </td>
                                <td style="width:80px;" >
                                    <img src="{{ $render_one->pic }}" alt="用户头像" class="user_pic" />
                                </td>
                                <td tyle="width:120px;" >
                                    <font color="#2b2b2b">{{ $render_one->name }}</font>
                                </td>
                                <td style="width:400px;" class="comment_content">
                                    {{ $render_one->content }}
                                </td>
                                <td style="width:100px;" >
                                    {{ $render_one->updated_at }}
                                </td>
                                <td style="width:100px;" >
                                    {{ $render_one->created_at }}
                                </td>

                                <td style="width:100px;" >
                                    {{ $comment_status[$render_one->status] }}
                                </td>


                                <td data-comment_id="{{ $render_one->id }}" data-field="status">
                                    <!-- 正常 -->
                                    @if( $render_one->status != \App\Models\Blog\Comment::STATUS_NORMAL  )
                                    <button class="btn btn-default comment_change" 
                                        data-val="{{ \App\Models\Blog\Comment::STATUS_NORMAL }}" 
                                    >正常</button>
                                    @endif
                                    <!-- 锁定 -->
                                    @if( $render_one->status != \App\Models\Blog\Comment::STATUS_LOCK  )
                                    <button class="btn btn-warning comment_change" 
                                        data-val="{{ \App\Models\Blog\Comment::STATUS_LOCK }}" 
                                    >锁定</button>
                                    @endif
                                </td>

                                <td data-comment_id="{{ $render_one->id }}" data-field="is_deleted">
                                    <button class="btn btn-danger comment_change" 
                                        data-val="{{ \App\Models\Blog\Comment::IS_DELETED_YES }}"
                                     >删除</button>
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
<script src="/static_pc/admin/js_v3.0/comment.js"></script>
@endsection