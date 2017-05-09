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
    protected $fillable = ['id', 'parent_id', 'cat_name', 'keywords', 'description', 'cat_ico', 'order', 'is_show'];

    /**
     * The attributes should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [''];

    protected $casts = [
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'cat_id');
    }
}