<?php

namespace App\Repositories;

use DB;
use Parsedown;
use App\Models\Post;
//use App\Models\Category;
//use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class PostRepository
{

    /**
     * Get all posts order by publish date.
     *
     * @param int $limit
     * @param boolean $manage
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($limit = 8, $manage = false)
    {
        $prepare = Post::orderBy('created_at', 'desc');

        $prepare->list();

        return $prepare->paginate((int)$limit);
    }

    /**
     * Get record(s) by given column.
     *
     * @param  string $column
     * @param  mixed $value
     * @return \Illuminate\Support\Collection|\App\Models\Post
     */
    public function getByColumn($column, $value)
    {
        $prepare = Post::where($column, $value)->show();

        return $prepare->get();
    }


    /**
     * Like the post.
     *
     * @param int $postID
     */
    public function likePost($postID)
    {
        return Post::where('id', $postID)->increment('favorite_count');
    }

    /**
     * Group all dates with posts published, group by year/month.
     *
     * @return array
     */
    public function groupDates()
    {
        $dates = Post::selectRaw('year(created_at) year, month(created_at) month')
            ->groupBy('year', 'month')
            ->orderByRaw('min(created_at) desc')
            ->get();

        $years = $dates->groupBy('year')
            ->map(function ($year, $index) {
                return [
                    'year' => $index,
                    'months' => $year->groupBy('month')->keys()
                ];
            });

        return $years->values();
    }

    /**
     * Get articles posted in year-month.
     *
     * @param string $yearMonth
     */
    public function getPostsByYearMonth($yearMonth)
    {
        $date = explode('-', $yearMonth);
        return Post::select('id', 'title', 'slug')
            ->whereYear('created_at', $date[0])
            ->whereMonth('created_at', $date[1])
            ->get();
    }

    /**
     * Get post count.
     *
     * @return int
     */
    public function getPostCount()
    {
        return Post::count();
    }

    /**
     * Toggle post published state.
     *
     * @param $id
     * @return boolean
     */
    public function togglePublish($id)
    {
        $post = Post::where('id', $id)->first();
        return $post->update(['published' => !$post->published]);
    }

    /**
     * Soft delete post.
     *
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        $post = Post::where('id', $id)->first();
        $post->tags()->sync([]);
        return $post->delete();
    }

    /**
     * Get original post data.
     * @param  int $id
     * @return array|boolean
     */
    public function origin($id)
    {
        $post = Post::where('id', $id)
            ->with('category', 'tags')
            ->first([
                'id', 'title', 'slug', 'summary', 'category_id',
                'origin', 'published', 'created_at', 'updated_at', 'exported_at'
            ]);

        if (is_null($post)) {
            return false;
        }

        $post = $post->toArray();
        $post['category'] = $post['category']['name'];
        $post['tags'] = array_column($post['tags'], 'name');
        return $post;
    }


    /**
     * Store post.
     *
     * @param $inputs
     * @return boolean
     */
    public function store($inputs)
    {
        $post = new Post();

        return $this->save($post, $inputs);
    }

    /**
     * Update post.
     *
     * @param $id
     * @param $inputs
     * @return bool
     */
    public function update($id, $inputs)
    {
        $post = Post::where('id', $id)->first();
        if (is_null($post)) {
            return false;
        }

        return $this->save($post, $inputs);
    }

    /**
     * Save post with given inputs.
     *
     * @param Post $post
     * @param $inputs
     * @return mixed
     */
    public function save(Post $post, $inputs)
    {
        $parser = new Parsedown();

        $post->title = $inputs['title'];
        $post->slug = $inputs['slug'];
        $post->summary = $inputs['summary'];
        $post->origin = $inputs['origin'];
        $post->body = $parser->parse($inputs['origin']);
        $post->published = $inputs['published'];
        // Begin transaction
        return DB::transaction(function () use ($post, $inputs) {
            $categorySync = $this->syncCategory($post, $inputs['category']);
            $postSaved = $post->save();
            $tagsSync = $this->syncTags($post, $inputs['tags']);

            return $postSaved && $categorySync && $tagsSync;
        });
    }

    /**
     * Associate post with category.
     *
     * @param Post $post
     * @param $categoryName
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function syncCategory(Post $post, $categoryName)
    {
        $category = Category::where('name', $categoryName)->first();
        if (is_null($category)) {
            $category = Category::create(['name' => $categoryName]);
        }
        return $post->category()->associate($category);
    }

    /**
     * Synchronize post tags relation.
     *
     * @param Post $post
     * @param $tags
     * @return array
     */
    public function syncTags(Post $post, $tags)
    {
        $tagCollection = Tag::whereIn('name', $tags)->get(['name']);
        // Insert non-existent tags.
        $uncreatedTags = array_diff($tags, array_values($tagCollection->pluck('name')->toArray()));
        $now = Carbon::now();
        Tag::insert(
            array_map(function ($item) use ($now){
                return ['name' => $item, 'created_at' => $now, 'updated_at' => $now];
            }, $uncreatedTags)
        );

        $ids = Tag::whereIn('name', $tags)->get(['id'])->pluck('id')->toArray();

        return $post->tags()->sync($ids);
    }

    /**
     * Update export timestamp without mutate updated_at column.
     *
     * @param $id
     * @param $now
     * @return int
     */
    public function updateExportedAt($id, $now)
    {
        return Post::where('id', $id)->getQuery()->update(['exported_at' => $now]);
    }

    /**
     * Get all post for sitemaps.
     *
     */
    public function sitemaps()
    {
        return Post::wherePublished(1)->get(['slug', 'updated_at']);
    }

}
