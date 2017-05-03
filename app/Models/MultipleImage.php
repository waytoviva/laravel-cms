<?php
/**
 * Created by PhpStorm.
 * User: pyua01
 * Date: 2017/3/11
 * Time: 16:03
 */

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MultipleImage extends Model
{
    use AdminBuilder;
    protected $table = 'multiple_images';

    public function setPicturesAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['pictures'] = json_encode($pictures);
        }
    }

    public function getPicturesAttribute($pictures)
    {
        return json_decode($pictures, true);
    }
}