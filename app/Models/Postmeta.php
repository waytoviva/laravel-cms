<?php
/**
 * Post Meta Model
 * User: yejiancong
 * Date: 2017/3/10
 * Time: 15:31
 */

namespace App\Models;


use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;

class Postmeta extends Model
{
    use AdminBuilder;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'postmeta';

    protected $primaryKey = 'meta_id';

    protected $fillable = ['meta_id', 'post_id', 'meta_key', 'meta_value'];

    public $timestamps = false;

    /**
     * post
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }



}