<?php
/**
 * Options Model
 * User: yejiancong
 * Date: 2017/3/11
 * Time: 13:31
 */

namespace App\Models;


use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;


class Option extends Model
{
    use AdminBuilder;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'options';

    protected $primaryKey = 'option_id';

    protected $fillable = ['option_id', 'option_name', 'option_value'];

    public $timestamps = false;

    protected $casts = [
        'option_value' => 'json',
    ];

    public function setOptionsAttribute($options)
    {
        if (is_array($options)) {
            $this->attributes['options'] = join(',', $options);
        }
    }

    public function getOptionsAttribute($options)
    {
        if (is_string($options)) {
            return explode(',', $options);
        }

        return $options;
    }
}