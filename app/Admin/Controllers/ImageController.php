<?php

namespace App\Admin\Controllers;

use App\Models\Image;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\Tools\GridView;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;


class ImageController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('头像');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('头像');
            $content->description('编辑');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('头像');
            $content->description('创建');

            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return Admin::grid(Image::class, function (Grid $grid) {

            $grid->id('ID');

            $grid->caption()->limit(20);

            $grid->image()->image();

            $grid->created_at();

            $grid->tools(function ($tools) {
                $tools->append(new GridView());
            });


            //$grid->view('admin.grid.card');
//            if (Request::get('view') !== 'table') {
//                $grid->view('admin.grid.card');
//            }

        });
    }

    public function form()
    {
        return Admin::form(Image::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('caption');

            $form->image('image');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    /**
     * 针对editor.md所写的图片上传控制器
     *
     * @param  Request $requst
     * @return Response
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('wang-editor-image-file')) {
            //
            $file = $request->file('wang-editor-image-file');
            $data = $request->all();
            $rules = [
                'wang-editor-image-file'    => 'max:5120',
            ];
            $messages = [
                'wang-editor-image-file.max'    => '文件过大,文件大小不得超出5MB',
            ];
            $validator = Validator::make($data, $rules, $messages);
            $res = 'error|失败原因为：非法传参';
            if ($validator->passes()) {
                $realPath = $file->getRealPath();
                $destPath = 'uploads/content/';
                $savePath = $destPath.''.date('Ymd', time());
                is_dir($savePath) || mkdir($savePath);  //如果不存在则创建目录
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
            } else {
                $res = 'error|'.$validator->messages()->first();
            }
        }
        return $res;
    }

}
