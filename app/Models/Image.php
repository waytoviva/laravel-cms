<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
   // use SoftDeletes, AdminBuilder;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'images';


}
