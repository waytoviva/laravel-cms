<?php
/**
 * link
 * User: Yang
 * Date: 2017/3/11
 * Time: 19:48
 */

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use ModelTree, AdminBuilder;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'links';

    protected $primaryKey = 'link_id';

    /**
     * The mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['link_id', 'link_url', 'link_name', 'link_image', 'link_target', 'link_description'];
}