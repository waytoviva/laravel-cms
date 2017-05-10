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
    public function show($id)
    {
        $post = Post::where(['post_type' => 'post', 'released' => 1])->find((int)$id);

        if (empty($post)) {
            abort(404);
        }



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

        return view('cms.post', ['post' => $post, 'previous' => $previous, 'next' => $next]);
    }
}