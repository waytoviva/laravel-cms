<?php

namespace App\Admin\Controllers;

use App\Models\Post;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class PageController extends Controller
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

            $content->header('页面管理');
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

            $content->header('页面管理');
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

            $content->header('页面管理');
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
        return Admin::grid(Post::class, function (Grid $grid) {

            $grid->model()->where('post_type','page');
            $grid->id('ID')->sortable();

            $grid->post_tag('页面标示')->value(function ($post_tag) {
                return "<a href='".route('cms.page', $post_tag)."' target='_blank'>$post_tag</a>";
            });

            $grid->post_title('标题')->ucfirst()->limit(70);
            $grid->post_hits('点击次数');
            $grid->created_at('发布时间');


            $states = [
                'on' => ['text' => 'YES'],
                'off' => ['text' => 'NO'],
            ];

            $grid->released('发布状态')->switch($states);



            $grid->filter(function ($filter) {
                $filter->like('post_title', '标题');
                $filter->equal('released', '状态')->select([ 1 => '已发布', 0 => '隐藏']);
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
        return Admin::form(Post::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('post_title', '标题')->rules('required|min:1');

            $form->text('post_tag', '页面标示')->rules('required');

            $form->editor('post_content', '内容')->default('');

            $form->hidden('post_type')->default('page');

            $form->textarea('post_excerpt', '摘要');

            $form->divide();

            $form->switch('released', '发布？');
            //$form->switch('comment_status', '评论状态');

            $form->divide();

            $form->switch('carousel', '轮播');

            $form->divide();

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');

            $form->hasMany('postmeta', function (Form\NestedForm $form) {
                $form->select('meta_key', '类型')->options([
                    'keywords' => 'SEO关键词',
                    'description' => 'SEO描述内容',
                    'from' => '来源',
                ]);

                $form->textarea('meta_value', '值');
            });
        });
    }
}
