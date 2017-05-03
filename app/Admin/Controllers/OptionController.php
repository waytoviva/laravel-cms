<?php

namespace App\Admin\Controllers;

use App\Models\Option;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class OptionController extends Controller
{
    use ModelForm;

    protected $id;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('设置');
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

            $content->header('设置');
            $content->description('编辑');
            $this->id = $id;
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

            $content->header('设置');
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
        return Admin::grid(Option::class, function (Grid $grid) {

            $grid->option_id('ID')->sortable();

            $grid->option_name('名字');
            $grid->option_value('值');



        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Option::class, function (Form $form) {
            if ($this->id == 1) {
                //常用设置
                $form->html('<input type="hidden" name="option_name" value="setting" class="option_name">');
                $form->embeds('option_value', '常用设置', function ($form) {
                    $form->text('site_name', '网站名');
                    $form->url('site_url', '网站url');
                    $form->text('site_keyword', '网站关键词');
                    $form->textarea('site_description', '网站描述');
                    $form->text('site_copyright', '版权');
                    $form->text('hot_line', '热线');
                    $form->text('office_hours', '公司上班时间');
                    $form->text('company_name', '公司名称');
                    $form->text('company_address', '公司地址');
                    $form->text('miitbeian', '备案号');
                    $form->text('meta_author', 'Meta Author');
                });

            } else {
                $form->display('option_id', 'ID');
                $form->text('option_name', '名字');
                $form->textarea('option_value', '值');
                $form->saved(function () {
                    //设置cache
                    $option_name = request()->get('option_name');
                    if ($option_name == 'setting') {
                        $option = Option::where('option_name', 'setting')->first();

                        foreach ($option->option_value as $key => $value) {
                            cache()->forever('setting.'.$key, $value);
                        }
                    } else {
                        cache()->forever('setting.'.$option_name, Option::where('option_name', $option_name)->pluck('option_value')->first());
                    }

                });

            }





        });
    }
}
