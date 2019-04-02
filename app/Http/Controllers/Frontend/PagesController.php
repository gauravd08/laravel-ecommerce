<?php
namespace App\Http\Controllers\Frontend;

class PagesController extends \App\Http\Controllers\Controller
{

    public function home()
    {
        return view('Frontend.home');
    }


}