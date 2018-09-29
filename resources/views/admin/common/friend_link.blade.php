<!-- 继承页面 -->
@extends('admin.public.layout')
<!-- 页面标题 -->
@section('title') 友情链接 @endsection
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
                                    <button class="btn btn-default friend_link_create"><span class="fa fa-pencil-square-o"></span> 
                                        创建
                                    </button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-hover" id="treeTable">
                        <thead>
                            <th>
                                ID
                            </th>
                            <th>
                                站点名
                            </th>
                            <th>
                                链接
                            </th>
                            <th>
                                权重值
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
                                <td >
                                    {{ $render_one->id }}
                                </td>

                                <td style="color: #e0e;width:200px;" >
                                    <div class="form-group">
                                        <input type="text" id="title_{{ $render_one->id }}" value="{{ $render_one->title }}"
                                         placeholder="请输入站点名..." class="form-control" required />
                                    </div>
                                </td>

                                <td style="color: #e0e;width:400px;">
                                    <div class="form-group">
                                        <input type="text" id="href_{{ $render_one->id }}" value="{{ $render_one->href }}"
                                         placeholder="请输入站点链接..." class="form-control" required />
                                    </div>
                                </td>

                                <td style="width:120px;">
                                    <div class="form-group">
                                        <input type="text" id="weight_{{ $render_one->id }}" value="{{ $render_one->weight }}"
                                         placeholder="请输入权重值..." class="form-control" required />
                                    </div>
                                </td>

                                <td >
                                    {{ $render_one->updated_at }}
                                </td>

                                <td >
                                    {{ $render_one->created_at }}
                                </td>

                                <td data-friend_link_id="{{ $render_one->id }}">
                                    <button class="btn btn-info friend_link_update">更新</button>
                                    <button class="btn btn-danger friend_link_delete">删除</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
<!-- 前端逻辑 -->
<script src="/static_pc/admin/js_v3.0/friend_link.js"></script>
@endsection