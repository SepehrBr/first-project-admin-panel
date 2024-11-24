<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $this
            ->seo()
            ->setTitle('Landing-Page')
            ->setDescription('Welcome To Laravel Pro')
            ;
        auth()->loginUsingId(1);
        return view('index');
    }
}
