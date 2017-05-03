<?php
/**
 * sku
 * User: Yang
 * Date: 2017/3/11
 * Time: 19:48
 */

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use ModelTree, AdminBuilder;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'navigation';

    /**
     * The mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['id', 'parent_id', 'order', 'title', 'logo', 'module'];

    public function parentNavigation()
    {
        return $this->belongsTo(Navigation::class, 'parent_id', 'id');
    }

    public function childrenNavigation()
    {
        return $this->hasMany(Navigation::class, 'parent_id', 'id');
    }
}