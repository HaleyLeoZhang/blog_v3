<?php

namespace App\Http\Controllers\Admin\Upload;

/**
 * 用户账号管理操作相关
 */
use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\UploadRepository;

class ApiController extends BaseController
{

    /**
     * @api {post} /admin/upload/markdown 图片上传-markdown
     * @apiName markdown
     * @apiGroup upload
     *
     * @apiDescription  图片上传-markdown
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     */
    public function markdown()
    {
        list($path, $type, $size) = $this->check_has_file('editormd-image-file');
        $file_info = compact('path', 'type', 'size');
        $data      = UploadRepository::markdown($file_info);
        return json_encode($data);
    }

    /**
     * @api {post} /admin/upload/editor 图片上传-editor
     * @apiName editor
     * @apiGroup upload
     *
     * @apiDescription  图片上传-editor
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     */
    public function editor()
    {
        list($path, $type, $size) = $this->check_has_file('upfile');
        $file_info = compact('path', 'type', 'size');
        $data      = UploadRepository::editor($file_info);
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
