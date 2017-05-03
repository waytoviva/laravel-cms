<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes, AdminBuilder;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'contact';

    /**
     * The mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'mobile', 'message'];

    /**
     * The attributes should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [''];

    protected $casts = [];



}
