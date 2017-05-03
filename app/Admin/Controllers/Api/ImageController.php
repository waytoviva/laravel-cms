<?php

namespace App\Admin\Controllers\Api;

use App\Models\Image;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class ImageController extends Controller
{


    /**
     * 针对editor.md所写的图片上传控制器
     *
     * @param  Request $requst
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            //
            $file = $request->file('image');
            $data = $request->all();
            $rules = [
                'wang-editor-image-file'    => 'max:5120',
            ];
            $messages = [
                'wang-editor-image-file.max'    => '文件过大,文件大小不得超出5MB',
            ];
            //$validator = Validator::make($data, $rules, $messages);
            $res = 'error|失败原因为：非法传参';
            //if ($validator->passes()) {
                $realPath = $file->getRealPath();
                $destPath = 'upload/content/';
                $savePath = $destPath.''.date('Ymd', time());
                //is_dir($savePath) || mkdir($savePath);  //如果不存在则创建目录
                $name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $check_ext = in_array($ext, ['gif', 'jpg', 'jpeg', 'png'], true);
                if ($check_ext) {
                    $uniqid = uniqid().'_'.date('s');
                    $oFile = $uniqid.'o.'.$ext;
                    $fullfilename = '/'.$savePath.'/'.$oFile;  //原始完整路径
                    if ($file->isValid()) {
                        $uploadSuccess = $file->move($savePath, $oFile);  //移动文件
                        $oFilePath = $savePath.'/'.$oFile;
                        $res = $fullfilename;
                    } else {
                        $res = 'error|失败原因为：文件校验失败';
                    }
                } else {
                    $res = 'error|失败原因为：文件类型不允许,请上传常规的图片(gif、jpg、jpeg与png)文件';
                }
            //} else {
                //$res = 'error|'.$validator->messages()->first();
            //}
        }
        return $res;
    }

}
