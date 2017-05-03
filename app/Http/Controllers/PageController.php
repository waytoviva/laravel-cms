<?php
/**
 * 页面
 * User: yejiancong
 * Date: 2017/3/15
 * Time: 18:39
 */

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Carousel;


class PageController extends Controller
{
    public $module = 'page';

    public function index()
    {

        return $this->show('/');
    }

    public function show($slug)
    {

        $post = Post::show()
            ->where(['post_type' => 'page', 'released' => 1, 'post_tag' => $slug])
            ->first();

        if (empty($post)) {
            abort(404);
        }

        //增加meta_keywords和meta_description等数据
        foreach ($post->postmeta as $meta) {
            $meta_key = 'meta_'.$meta->meta_key;
            $post->$meta_key = $meta->meta_value;
        }

        //hits add 1
        $post->increment('post_hits');

        $curr[$slug] = 'curr';

        if ($slug == '/') {
            $carousel = Carousel::where('is_show', 1)
                ->get();
            $slug = 'index';
        }

        if (view()->exists('cms.'.$slug)) {
            $view = 'cms.'.$slug;
        } else {
            $view = 'cms.page';
        }

        return view($view, ['post' => $post, 'curr' => $curr, 'carousel' => isset($carousel) ? $carousel : '']);

    }


}