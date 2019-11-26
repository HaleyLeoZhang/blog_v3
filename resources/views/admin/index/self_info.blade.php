<!-- 继承页面 -->
@extends('admin.public.layout')
<!-- 页面标题 -->
@section('title') 帐号操作 @endsection
<!-- 功能备注 -->
@section('mark') 目前仅支持修改密码 @endsection
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
                        </div>
                    </div>
                    <table class="table table-bordered table-hover" id="treeTable">
                        <thead>
                            <th>
                                功能名
                            </th>
                            <th>
                                修改值
                            </th>
                            <th>
                                操作
                            </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="color: #e0e;width:400px;">
                                    <h5>修改密码</h5>
                                </td>
                                <td style="color: #e0e;width:400px;">
                                    <div class="form-group">
                                        <input type="text" id="password"
                                         placeholder="请输入密码..." class="form-control" required />
                                    </div>
                                </td>
                                <td >
                                    <button type="button" class="btn btn-info sub_pwd_edit">提交</button>
                                </td>
                            </tr>
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
<script src="{{ config('static_source_cdn.layer') }}"></script>
<script src="/static_pc/js/hlz_rsa.js"></script>
<script src="/static_pc/admin/js_v3.0/self_info.js"></script>
@endsection