<?php

namespace App\Admin\Controllers;

use App\Models\Contact;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ContactController extends Controller
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

            $content->header('联系我们');
            $content->description('Contact');

            $content->body($this->grid());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Contact::class, function (Grid $grid) {

            $grid->disableCreation();

            $grid->id('ID')->sortable();

            $grid->name('姓名');
            $grid->email('邮箱');
            $grid->mobile('电话');
            $grid->message('留言信息');

        });
    }
}
