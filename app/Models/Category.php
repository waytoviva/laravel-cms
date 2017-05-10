<?php
namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use AdminBuilder;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'category';

    /**
     * The mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['id', 'name'];

    /**
     * The attributes should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [''];
}