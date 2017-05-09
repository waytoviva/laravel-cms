<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes, AdminBuilder;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['post_title', 'post_excerpt', 'released', 'post_content', 'logo'];

    /**
     * The attributes should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];

    protected $casts = [
        'released' => 'boolean'
    ];

    public function setLogoAttribute($logo)
    {
        if (is_array($logo)) {
            $this->attributes['logo'] = json_encode($logo);
        }
    }

    public function getLogoAttribute($logo)
    {
        return json_decode($logo, true);
    }

    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable', 'taggables');
    }

    /**
     * One to many relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * One to many relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * Guest scope.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShow($query)
    {
        return $query->select([
            'id', 'post_title', 'post_excerpt', 'released', 'post_content', 'created_at'
        ])->whereReleased(1);
    }

    /**
     * Guest list scope.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeList($query)
    {
        return $query->select([
            'id', 'post_title', 'post_excerpt', 'released', 'created_at'
        ])->whereReleased(1);
    }

    /**
     * Manager scope.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeManage($query)
    {
        return $query->select('id', 'post_title', 'post_excerpt', 'released', 'post_content');
    }

    /**
     * App scope.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApp($query)
    {
        return $query->select('id', 'post_title');
    }


    /**
     * 关联postmeta
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postmeta()
    {
        return $this->hasMany(Postmeta::class, 'post_id');
    }


}
