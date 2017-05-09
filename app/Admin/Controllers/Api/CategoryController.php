<?php

namespace App\Admin\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{

    /**
     * Load options for select.
     *
     * GET /admin/api/category?q=xxx
     *
     * @param Request $request
     * @return mixed
     */

    public function index()
    {
        $q = request()->get('q');

        return Category::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }
}