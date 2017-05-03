<?php

namespace App\Admin\Controllers;

use App\Models\Carousel;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Tree;

class CarouselController extends Controller
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

            $content->header('轮播图');
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

            $content->header('轮播图');
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

            $content->header('轮播图');
            $content->description('新建');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Carousel::tree(function (Tree $tree) {

            $tree->branch(function ($branch) {

                $src = config('admin.upload.host') . '/' . $branch['logo'] ;

                $logo = "<img src='$src' style='max-width:30px;max-height:30px' class='img'/>";

                $is_show = $branch == '0' ? '隐藏' : '显示';

                return "[{$branch['id']}] - [{$branch['title']}] $logo [链接: {$branch['url']}] [$is_show]";

            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Carousel::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->image('logo', '图片')->rules('required')->uniqueName()->move(config('admin.upload.directory.image').'/'.date('Ym'));

            $form->text('url', '跳转链接');

            $form->text('title', '图片标题');

            $form->switch('is_show', '是否显示');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }

    /**
     * POST /admin/posts/release
     *
     * @param Request $request
     * @return void
     */
    public function release(Request $request)
    {
        foreach (Post::find($request->get('ids')) as $post) {
            $post->is_show = $request->get('action');
            $post->save();
        }
    }
}
