<!-- 内容开始 -->
<!-- 1.1.2.剪切图片插件引入 -->
<link href="{:link_plugins('pic_cut','bootstrap.min.css')}" rel="stylesheet">
<link href="{:link_plugins('pic_cut','cropper.min.css')}" rel="stylesheet">
<link href="{:link_plugins('pic_cut','main.css')}" rel="stylesheet">
<div id="crop-avatar">
  <!--初始图片宽高比-->
  <input type="hidden" id="get_aspectRatio_w" value="100" placeholder="宽">
  <input type="hidden" id="get_aspectRatio_h" value="100" placeholder="高">
  <!-- Current avatar -->
  <div class="avatar-view" title="继续传图片">
    <!-- 这里的 onkeyup 为回调函数，无其他意义 ，yth-data-pic_id为图片在数据库的id-->
    <img src="/static_pc/plugins/pic_cut/img/picture.jpg" alt="Avatar" onkeyup="" pic_id=""></div>
  <!-- Cropping modal -->
  <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!--这里配置 图片处理地址-->
        <form class="avatar-form" action="/Api?con=Do_crop&act=goods&gid=1" enctype="multipart/form-data" method="post">
          <div class="modal-header">
            <button class="close" data-dismiss="modal" type="button">&times;</button>
            <h4 class="modal-title" id="avatar-modal-label">
              <strong>上传图片</strong></h4>
          </div>
          <div class="modal-body">
            <div class="avatar-body">
              <!-- Upload image and data -->
              <div class="avatar-upload">
                <input class="avatar-src" name="avatar_src" type="hidden">
                <input class="avatar-data" name="avatar_data" type="hidden">
                <input class="avatar-input" id="avatarInput" name="avatar_file" type="file"></div>
              <!-- Crop and preview -->
              <div class="row">
                <div class="col-md-9">
                  <div class="avatar-wrapper"></div>
                </div>
                <div class="col-md-3">
                  <h2>
                    <b>效果预览</b>
                  </h2>
                  <div class="avatar-preview preview-lg"></div>
                </div>
              </div>
              <div class="row avatar-btns">
                <div class="col-md-9">
                  <div class="btn-group">
                    <button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees">顺时针90°</button>
                    <button class="btn btn-primary" data-method="rotate" data-option="-15" type="button">15°</button>
                    <button class="btn btn-primary" data-method="rotate" data-option="-30" type="button">30°</button>
                    <button class="btn btn-primary" data-method="rotate" data-option="-45" type="button">45°</button></div>
                  <div class="btn-group">
                    <button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees">逆时针90°</button>
                    <button class="btn btn-primary" data-method="rotate" data-option="15" type="button">15°</button>
                    <button class="btn btn-primary" data-method="rotate" data-option="30" type="button">30°</button>
                    <button class="btn btn-primary" data-method="rotate" data-option="45" type="button">45°</button></div>
                </div>
                <div class="col-md-3">
                  <button class="btn btn-primary btn-block avatar-save" type="submit">完成</button></div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /.modal -->
  <!-- Loading state -->
  <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
</div>
<!--如果资源存在，则不需要引入 -->
<script type="text/javascript" src="//libs.baidu.com/jquery/1.9.1/jquery.js"></script>
<script src="{:link_plugins('pic_cut','bootstrap.min.js')}"></script>
<script src="{:link_plugins('pic_cut','cropper.min.js')}"></script>
<!--前面类库都存在了，再执行main.js -->
<script src="{:link_plugins('pic_cut','main.js')}"></script>
<!-- 2.1.0封面图片截取 结束-->