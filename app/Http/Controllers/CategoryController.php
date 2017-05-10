<?php
/**
 * 分类
 * User: yejiancong
 * Date: 2017/5/10
 * Time: 11:22
 */

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;


class CategoryController extends Controller
{
    public function show($id)
    {
        $category = Category::find((int)$id);

        if (empty($category)) {
            abort(404);
        }

        $post = new \stdClass();
        $post->post_title = $category->name;
        $post->meta_keywords = $category->name;
        $post->meta_description = $category->intro;

        //列表
        $post_list = Post::where(['category_id' => $id, 'post_type' => 'post', 'released'=>1])
            ->orderBy('created_at', 'desc')
            ->paginate(7);

        return view('cms.category', [
            'post' => $post,
            'category' => $category,
            'post_list'=>$post_list
        ]);
    }


}