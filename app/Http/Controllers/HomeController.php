<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // トップページを表示するメソッド
    public function index()
    {
        // resources/views/home/index.blade.php を表示する
        return view('home.index');
    }
}
