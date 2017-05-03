<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Carousel extends Model
{
    use ModelTree, AdminBuilder, SoftDeletes;

    protected $table = 'carousel';
}
