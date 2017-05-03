<?php
/**
 * Created by PhpStorm.
 * User: pyua01
 * Date: 2017/3/9
 * Time: 09:52
 */

namespace App\Http\Controllers;


class TestController extends Controller
{
    public function index()
    {
        return $this->show('/');
    }
    public function show()
    {
        return $this->view('cms.test');
    }

}