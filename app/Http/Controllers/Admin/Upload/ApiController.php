<?php

namespace App\Http\Controllers\Admin\Upload;

/**
 * 用户账号管理操作相关
 */
use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Bussiness\Admin\UploadBussiness;

class ApiController extends BaseController
{

    /**
     * @api {post} /admin/upload/markdown 图片上传-markdown
     * @apiName markdown
     * @apiGroup upload
     *
     * @apiParam {file} editormd-image-file 待上传的图片
     *
     * @apiDescription  图片上传-markdown
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "success": 1,
     *     "url": "\/\/tencent.cdn.hlzblog.top\/blog\/upload\/img\/2018_09_29_KAsu7WUa.jpg"
     * }
     */
    public function markdown()
    {
        list($path, $type, $size) = $this->check_has_file('editormd-image-file');
        $file_info = compact('path', 'type', 'size');
        $data      = UploadBussiness::markdown($file_info);
        return json_encode($data);
    }

    /**
     * @api {post} /admin/upload/editor 图片上传-editor
     * @apiName editor
     * @apiGroup upload
     *
     * @apiParam {file} upfile 待上传的图片
     *
     * @apiDescription  图片上传-editor
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "state": "SUCCESS",
     *     "url": "\/\/tencent.cdn.hlzblog.top\/blog\/upload\/img\/2018_09_29_QLSwfPWw.jpg",
     *     "title": "\u67e5\u770b\u56fe\u7247",
     *     "original": "-"
     * }
     */
    public function editor()
    {
        list($path, $type, $size) = $this->check_has_file('upfile');
        $file_info = compact('path', 'type', 'size');
        $data      = UploadBussiness::editor($file_info);
        return json_encode($data);
    }


    protected function check_has_file($file_name){
        if (!isset($_FILES[$file_name])) {
            throw new \ApiException(null, \Consts::VALIDATE_PARAMS);
        }
        $path      = $_FILES[$file_name]['tmp_name'];
        $type = $_FILES[$file_name]['type'];
        $size = $_FILES[$file_name]['size'];
        return [
            $path,
            $type,
            $size,
        ];
    }

}
