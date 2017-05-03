<?php

namespace App\Admin\Controllers;

use App\Models\Navigation;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Tree;

class NavigationController extends Controller
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

            $content->header('导航');
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

            $content->header('导航');
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

            $content->header('导航');
            $content->description('新建');

            $content->body($this->form());
        });
    }


    protected function grid()
    {
        return Navigation::tree(function (Tree $tree) {

            $tree->branch(function ($branch) {

                if ($branch['logo']) {
                    $src = config('admin.upload.host') . '/' . $branch['logo'] ;

                    $logo = "<img src='$src' style='max-width:30px;max-height:30px' class='img'/>";
                } else {
                    $logo = '';
                }

                return "{$branch['order']} - {$branch['title']} - {$branch['url']} $logo";

            });

        });
    }

    protected function form()
    {
        return Navigation::form(function (Form $form) {

            $form->display('id', 'ID');

            $form->select('parent_id', '上级')->options(Navigation::selectOptions());

            $form->text('title', '标题');
            $form->text('url', '地址')->rules('required');
            $form->textarea('describe', '说明');
            $form->image('logo')->uniqueName()->move(config('admin.upload.directory.image').'/'.date('Ym'));

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');

            $form->saved(function () {
                //设置cache
                cache()->forever('navigation', Navigation::where('parent_id', 0)
                    ->with('childrenNavigation')
                    ->orderBy('order', 'asc')
                    ->get());
            });
        });
    }
}
