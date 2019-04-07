<?php
namespace App\Http\Controllers\Frontend;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use Validator;
use Illuminate\Support\Facades\Input;
class PagesController extends \App\Http\Controllers\Controller
{

    public function home()
    {
        $banners = \App\Models\Graphic::where('type', GRAPHIC_TYPE_HOME_BANNER)->where('is_active', 1)->get();
        $title = "Home";
        return view('Frontend.Pages.home')->with(compact('banners','title'));
    }


}