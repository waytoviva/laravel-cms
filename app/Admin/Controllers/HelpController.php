<?php

namespace App\Admin\Controllers;

use App\Models\Post;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class HelpController extends Controller
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

            $content->header('帮助中心');
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

            $content->header('帮助中心');
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

            $content->header('帮助中心');
            $content->description('创建');

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


            $grid->model()->where('post_type','help');
            $grid->id('ID')->sortable()->value(function ($id) {
                return "<a href='".route('cms.help.show', $id)."' target='_blank'>$id</a>";
            });

            //$grid->post_tag('文章所属');

            $grid->post_title('标题')->ucfirst()->limit(70);
            $grid->created_at('发布时间');
            
            //$grid->logo('缩略图')->image();

            $states = [
                'on' => ['text' => 'YES'],
                'off' => ['text' => 'NO'],
            ];

            $grid->released('发布状态')->switch($states);

            $grid->column('switch_group', '设置')->switchGroup([
                'recommend' => '推荐', 'hot' => '热门', 'new' => '最新', 'carousel' => '轮播'
            ], $states);

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

            //$form->select('post_tag', '文章所属分类')->options(['company'=>'公司新闻', 'industry'=>'行业新闻', 'top'=>'头条新闻']);

            $form->hidden('post_type')->default('help');

            $form->editor('post_content', '内容')->default('')->rules('required|min:10');

            //$form->embeds('logo', '', function ($form) {
            //    $form->image('logo_list', '列表图片(199*162)')->uniqueName()->move(config('admin.upload.directory.image').'/'.date('Ym'));
            //    $form->image('logo_sidebar', '侧栏图片(310*173)')->uniqueName()->move(config('admin.upload.directory.image').'/'.date('Ym'));
            //});

            $form->textarea('post_excerpt', '摘要');

            $form->divide();

            $form->switch('released', '发布？');
            //$form->switch('comment_status', '评论状态');

            $form->divide();

            $form->switch('recommend', '推荐');
            $form->switch('hot', '最热');
            $form->switch('new', '最新');

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
