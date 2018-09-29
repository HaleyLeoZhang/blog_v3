<!-- 继承页面 -->
@extends('admin.public.layout')
<!-- 功能备注 -->
@section('mark') MD为Markdown，Editor为富文本。封面宽高比，建议16比9 @endsection
<!-- CSS -->
@section('css')
<link rel="stylesheet" href="{{ link_plugins('editor_md','editormd.min.css') }}">
<link rel="stylesheet" href="/Umeditor/themes/default/css/umeditor.min.css">
<link rel="stylesheet" href="/static_pc/admin/css_v3.0/checkbox_radio.css">
<style>
.col-xs-1.col-sm-1 {
    line-height: 35px;
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
                    <form id="article_edit">
                        <!-- 单行 -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1">
                                <label>标题</label>
                            </div>
                            <div class="col-xs-9 col-sm-9">
                                <div class="form-group">
                                    <input type="text"  name="title" value="{{ $render->title }}" placeholder="请输入文章名..." 
                                     class="form-control" data-article_id="{{ $render->id }}"  required />
                                </div>
                            </div>
                        </div>

                        <!-- 单行 -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1">
                                <label>文本类型</label>
                            </div>

                            <div class="col-xs-2 col-sm-2">

                                <div class="form-group">

                                    @foreach($list_edit_type as $item_edit_type )
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="radio radio-info radio_edit_type" data-id="{{ $item_edit_type }}">
                                            <input type="radio" 
                                                id="radio_edit_type_{{$item_edit_type}}"  
                                                value="{{$item_edit_type}}" 
                                                name="edit_type"
                                                {{ $item_edit_type == $render->type ? 'checked' : '' }}   
                                            />
                                            <label for="radio_edit_type_{{$item_edit_type}}"> 
                                                {{$text_edit_type[$item_edit_type]}} 
                                            </label>
                                        </div>
                                    </div>
                                     @endforeach


                                </div>
                            </div>


                            <div class="col-xs-1 col-sm-1">
                                <label>置顶操作</label>
                            </div>

                            <div class="col-xs-2 col-sm-2">

                                <div class="form-group">
                                    @foreach($list_sticky as $item_sticky )
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="radio radio-info ">
                                            <input type="radio" 
                                                id="radio_sticky_{{$item_sticky}}"  
                                                value="{{$item_sticky}}" 
                                                name="sticky"
                                                {{ $item_sticky == $render->sticky ? 'checked' : '' }}   
                                            />
                                            <label for="radio_sticky_{{$item_sticky}}"> 
                                                {{$text_sticky[$item_sticky]}} 
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-xs-1 col-sm-1">
                                <label>置顶序号</label>
                            </div>

                            <div class="col-xs-1 col-sm-1">
                                <div class="form-group">
                                    <input type="number"  name="sequence" value="{{ $render->sequence }}" placeholder="置顶序号" 
                                     class="form-control""  />
                                </div>
                            </div>
                        </div>

                        <!-- 单行 -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1">
                                <label>作品来源</label>
                            </div>

                            <div class="col-xs-2 col-sm-2">

                                <div class="form-group">
                                    @foreach($list_original as $item_original )
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="radio radio-info ">
                                            <input type="radio" 
                                                id="radio_original_{{$item_original}}"  
                                                value="{{$item_original}}" 
                                                name="original"
                                                {{ $item_original == $render->original ? 'checked' : '' }}   
                                            />
                                            <label for="radio_original_{{$item_original}}"> 
                                                {{$text_original[$item_original]}} 
                                            </label>
                                        </div>
                                    </div>
                                     @endforeach
                                </div>
                                
                            </div>

                            <div class="col-xs-1 col-sm-1">
                                <label>上线状态</label>
                            </div>

                            <div class="col-xs-2 col-sm-2">

                                <div class="form-group">

                                    @foreach($list_online as $item_online )
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="radio radio-info ">
                                            <input type="radio" 
                                                id="radio_online_{{$item_online}}"  
                                                value="{{$item_online}}" 
                                                name="online"
                                                {{ $item_online == $render->is_online ? 'checked' : '' }}   
                                            />
                                            <label for="radio_online_{{$item_online}}"> 
                                                {{$text_online[$item_online]}} 
                                            </label>
                                        </div>
                                    </div>
                                     @endforeach
                                </div>
                                
                            </div>
                        </div>



                        <!-- 单行 -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1">
                                <label>文章</label>
                            </div>
                            <!-- markdown 编辑器 -->
                            <div class="col-xs-9 col-sm-9"  
                                id="editor_0" 
                                {!! $render->type == \App\Models\Blog\Article::EDIT_TYPE_MARKDOWN ? '' : 'style="display:none"' !!}>
                                <div id="markdown" >
                                    <textarea style="display:none;">{!! $render->type == \App\Models\Blog\Article::EDIT_TYPE_MARKDOWN ? $render->raw_content : '' !!}</textarea> 
                                </div>

                            </div>

                            <!-- 富文本 编辑器 -->
                            <div class="col-xs-9 col-sm-9"  
                                id="editor_1" 
                                {!! $render->type == \App\Models\Blog\Article::EDIT_TYPE_EDITOR ? '' : 'style="display:none"' !!}>
                                <div 
                                    id="um_editor" 
                                    style="height:900px;width:800px;"
                                >{!! $render->type == \App\Models\Blog\Article::EDIT_TYPE_EDITOR ? $render->raw_content : ''!!}</div>
                            </div>
                        </div>


                        <!-- 单行 -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1">
                                <label>内容简述</label>
                            </div>
                            <div class="col-xs-9 col-sm-9">
                                <div class="form-group">
                                    <textarea id="descript"  
                                        placeholder="请在这里填写概述..."  
                                        class="form-control" 
                                        rows="5"
                                        name="descript"
                                    >{{ $render->descript }}</textarea>
                                </div>
                            </div>

                        </div>

                        <!-- 单行 -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1">
                                <label>封面图片</label>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <input type="text" id="cover_url" 
                                    value="{{ $render->cover_url }}"
                                    name="cover_url"
                                    placeholder="请输入封面图片地址..." class="layui-input">
                                </div>
                            </div>

                        </div>

                        <!-- 单行：封面图片预览 -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1">
                                <label></label>
                            </div>
                            <div class="col-xs-3 col-sm-3">
                                <div class="form-group">
                                    <img src="{{ $render->cover_url }}" alt="预览图片" id="cover_url_preview" 
                                    style="width:260px;height: 146px;">
                                </div>
                            </div>

                        </div>


                        <!-- 单行 radio 插件 http://www.jq22.com/demo/Checkboxes20161209/  -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1">
                                <label>所属分类</label>
                            </div>
                            <div class="col-xs-9 col-sm-9">
                                <div class="form-group">
                                    @foreach($category as $item )
                                    <div class="col-xs-2 col-sm-2">
                                        <div class="radio radio-info ">
                                            <input type="radio" id="radio_cate_id_{{$item->id}}"  
                                                value="{{$item->id}}" name="cate_id"
                                            {{ $item->id == $render->cate_id ? 'checked' : '' }}   >
                                            <label for="radio_cate_id_{{$item->id}}"> {{ $item->title  }} </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>                  
                            </div>
                        </div>



                        <!-- 单行 -->
                        <div class="row">
                            <div class="col-xs-1 col-sm-1">
                                <label>背景图片</label>
                            </div>
                            <div class="col-xs-9 col-sm-9">
                                <input type="hidden" id="bg_id" placeholder="这里是背景图" name="bg_id" value="{{ $render->bg_id }}">
                                <!-- 图片展示区-->
                                <div id="bg_html" style="width:800px;"></div>
                                <!-- 分页条-->
                                <div id="bg_html_pagenation" style="width:800px;margin-top:30px;"></div>
                            </div>

                        </div>


                        <!-- 单行 -->
                        <div class="row" style="margin-top:50px;">
                            <div class="col-xs-1 col-sm-1"></div>
                            <div class="col-xs-9 col-sm-9 btn btn-warning sub_form" type="button">
                                提交
                            </div>

                        </div>



                    </form>






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
<!-- 前端模板：背景图-->
<script type="text/yth_tpl" id="bg_tpl">
<%# for(var i=0; i <d.length; i++){ %> 
     <div class="col-xs-4 col-sm-4">
         <div class="radio radio-info bg_id_radio" data-id="<%d[i].id%>">
             <input type="radio" id="radio_bg_id_<%d[i].id%>"  
                 value="<%d[i].id%>" name="bg_id_radio"
             <% d[i].id == document.getElementById('bg_id').value  ? 'checked' : ''  %>   />
             <label for="radio_bg_id_<%d[i].id%>"> 
                <img src="<% d[i].url %>" width="190px" height="100px" alt="背景图">
            </label>
         </div>
     </div>
<%# } %>
</script>
@include('admin/article/common_script')
<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<!-- 初始化文章内容 -->
<script src="/Umeditor/umeditor.config.js"></script>
<script src="/Umeditor/umeditor.min.js"></script>
<script src="/static_pc/plugins/editor_md/editormd.min.js"></script>
<!-- 前端逻辑 -->
<script src="/static_pc/admin/js_v3.0/article_edit.js"></script>
@endsection