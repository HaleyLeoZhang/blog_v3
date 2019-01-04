<!-- 继承页面 -->
@extends('admin.public.layout')
<!-- 页面标题 -->
@section('title') 文章管理 @endsection
<!-- 功能备注 -->
@section('mark') 发布过的文章 @endsection
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
                        <div class="row">
                            <div class="col-xs-1 col-sm-1">
                                <div class="form-group">
                                    <button class="btn btn-default article_create"><span class="fa fa-pencil-square-o"></span> 立即创作</button>
                                </div>
                            </div>
                        </div>
                        <!-- 单行 -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1">
                                <label>创作类型</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <select class="form-control" name="original">
                                        @foreach(\App\Models\Blog\Article::$list_original as $item_original )
                                        <option value="{{$item_original}}" {{ $original == $item_original? 'selected': '' }} /> {{\App\Models\Blog\Article::$text_original[$item_original]}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1">
                                <label>编辑类型</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <select class="form-control" name="edit_type">
                                        @foreach(\App\Models\Blog\Article::$list_edit_type as $item_edit_type )
                                        <option value="{{$item_edit_type}}" {{ $edit_type == $item_edit_type? 'selected': '' }} /> {{\App\Models\Blog\Article::$text_edit_type[$item_edit_type]}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1">
                                <label>置顶状态</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <select class="form-control" name="sticky">
                                        @foreach(\App\Models\Blog\Article::$list_sticky as $item_sticky )
                                        <option value="{{$item_sticky}}" {{ $sticky == $item_sticky? 'selected': '' }} /> {{\App\Models\Blog\Article::$text_sticky[$item_sticky]}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1">
                                <label>上线状态</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <select class="form-control" name="online">
                                        @foreach(\App\Models\Blog\Article::$list_online as $item_online )
                                        <option value="{{$item_online}}" {{ $online == $item_online? 'selected': '' }} /> {{\App\Models\Blog\Article::$text_online[$item_online]}}
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
                                    <input type="text" class="form-control" id="time_start" name="time_start" value="{{$time_start}}">
                                </div>
                            </div>
                            <div class="col-xs-1 col-sm-1">
                                <label>结束日期</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="time_end" name="time_end" value="{{$time_end}}">
                                </div>
                            </div>

                            <div class="col-xs-1 col-sm-1">
                                <label>关键词</label>
                            </div>
                            <div class="col-xs-2 col-sm-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="标题或者概要等" id="vague" name="vague" value="{{$vague}}">
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
                <table class="table table-bordered table-hover" id="treeTable">
                    <thead>
                        <th>
                            ID
                        </th>
                        <th>
                            封面图
                        </th>
                        <th>
                            类别
                        </th>
                        <th>
                            文章名
                        </th>
                        <th>
                            概要
                        </th>
                        <th>
                            上线状态
                        </th>
                        <th>
                            置顶序号
                        </th>
                        <th>
                            更新时间
                        </th>
                        <th>
                            创建时间
                        </th>
                        <th>
                            操作
                        </th>
                    </thead>
                    <tbody>
                        @foreach($render as $render_one)
                        <tr>
                            <td style="width:70px;">
                                {{ $render_one->id }}
                            </td>
                            <td style="width:200px;">
                                <img src="{{$render_one->cover_url}}" alt="文章封面" width="160px" height="90px">
                            </td>
                            <td style="width:70px;">
                                {{ $render_one->cate_name }}
                            </td>
                            <td style="color: #e0e; width:200px;">
                                {{ $render_one->title }}
                            </td>
                            <td style="color: #C67171; width:400px; text-indent: 2em;">
                                {{ $render_one->descript }}
                            </td>
                            <td style="width:70px;">
                                {{ \App\Models\Blog\Article::$text_online[$render_one->is_online] }}
                            </td>
                            <td style="width:100px;">
                                @if( $render_one->sticky ) {{ $render_one->sequence }} @else 未置顶 @endif
                            </td>
                            <td style="width:120px;">
                                {{ $render_one->updated_at }}
                            </td>
                            <td style="width:120px;">
                                {{ $render_one->created_at }}
                            </td>
                            <td data-article_id="{{ $render_one->id }}" data-sticky="{{ $render_one->sticky }}">
                                <button class="btn btn-info look_through">查看</button>
                                <button class="btn btn-warning article_edit">修改</button>
                                <button class="btn btn-danger article_del">删除</button>
                                @if( $render_one->is_online == \App\Models\Blog\Article::IS_ONLINE_NO )
                                <button class="btn btn-success article_online">上线</button>
                                @else
                                <button class="btn btn-default article_offline">下线</button>
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
<script src="/static_pc/admin/js_v3.0/article_info.js"></script>
@endsection