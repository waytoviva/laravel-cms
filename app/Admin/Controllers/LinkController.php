<?php

namespace App\Admin\Controllers;

use App\Models\Link;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Tree;

class LinkController extends Controller
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

            $content->header('链接');
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

            $content->header('链接');
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

            $content->header('链接');
            $content->description('新建');

            $content->body($this->form());
        });
    }


    protected function grid()
    {
        return Link::tree(function (Tree $tree) {

            $tree->branch(function ($branch) {

                if ($branch['link_image']) {
                    $src = config('admin.upload.host') . '/' . $branch['link_image'] ;

                    $logo = "<img src='$src' style='max-width:30px;max-height:30px' class='img'/>";
                } else {
                    $logo = '';
                }

                return "{$branch['order']} - {$branch['link_name']} - {$branch['link_url']} $logo";

            });

        });
    }

    protected function form()
    {
        return Link::form(function (Form $form) {

            $form->display('link_id', 'ID');

            $form->text('link_name', '名称');
            $form->url('link_url', '链接')->rules('required');

            $form->select('link_target', '打开方式')->options(['_parent' => '原窗口打开', '_blank' => '新窗口打开']);

            $form->textarea('link_description', '说明');
            $form->image('link_image')->uniqueName()->move(config('admin.upload.directory.image').'/'.date('Ym'));

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');

            $form->saved(function () {
                //设置cache
                cache()->forever('links', Link::where('link_visible', 1)
                    ->orderBy('order', 'asc')
                    ->get());
            });
        });
    }
}
