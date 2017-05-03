<?php
/**
 * 内容
 * User: yejiancong
 * Date: 2017/3/9
 * Time: 15:21
 */

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public $module = 'news';

    public function index()
    {
        $post = Post::app()
            ->where(['post_type' => 'page', 'released' => 1, 'post_tag' => $this->module])
            ->first();

        if ($post) {
            //增加meta_keywords和meta_description等数据
            foreach ($post->postmeta as $meta) {
                $meta_key = 'meta_'.$meta->meta_key;
                $post->$meta_key = $meta->meta_value;
            }
            //hits add 1
            $post->increment('post_hits');
        } else {
            abort(404, '页面不存在');
        }

        //轮播
        $carousel_new = Post::where(['post_type' => 'post', 'carousel' => 1])
            ->pluck('logo', 'id')
            ->all();

        //最新
        $post_new = Post::where(['post_type' => 'post', 'released' => 1, 'new' => 1, 'carousel' => 0])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        //推荐
        $post_recommend = Post::where(['post_type' => 'post', 'released' => 1, 'recommend' => 1, 'carousel' => 0])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        //列表
        $post_list = Post::where(['post_type' => 'post', 'released'=>1])
            ->orderBy('created_at', 'desc')
            ->paginate(7);

        return view('cms.news', [
            'post' => $post,
            'carousel_new' => $carousel_new,
            'post_new'=>$post_new,
            'post_recommend'=>$post_recommend,
            'post_list' => $post_list]);
    }

    public function show($id)
    {
        $post = Post::where(['post_type' => 'post', 'released' => 1])->find((int)$id);

        $top_news = Post::where(['released'=>1, 'post_tag'=>'top'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $industry_news = Post::where(['post_type' => 'post', 'released'=>1, 'post_tag'=>'industry'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        //previous
        $previous = Post::where(['post_type' => 'post', 'released'=>1])
            ->where('id', '>', $id)
            ->pluck('id')
            ->first();
        //next
        $next = Post::where(['post_type' => 'post', 'released'=>1])
            ->where('id', '<', $id)
            ->orderBy('id', 'desc')
            ->pluck('id')
            ->first();

        //hits add 1
        Post::where('id', $id)
            ->increment('post_hits');
        return view('cms.newsshow', ['post' => $post, 'top_news'=>$top_news, 'industry_news'=>$industry_news, 'previous' => $previous, 'next' => $next]);
    }


}