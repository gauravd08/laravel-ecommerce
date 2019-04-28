<?php
namespace App\Http\Controllers\Frontend;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Models\Product;

class PagesController extends \App\Http\Controllers\Controller
{

    public function home()
    {
        $banners = \App\Models\Graphic::where('type', GRAPHIC_TYPE_HOME_BANNER)->where('is_active', 1)->get();
        $title = "Home";
        return view('Frontend.Pages.home')->with(compact('banners','title'));
    }

    /**
     * Serves the main Home page on front-end.
     */
    public function page($slug)
    {
        if($slug == 'women')
        {
            $records =  Product::with('ProductImage')->whereHas('Category', function($query) {
                return $query->where('parent_id','=', 2);
            })->get();
        }

        if($slug == 'men')
        {
            $records =  Product::with('ProductImage')->whereHas('Category', function($query) {
                return $query->where('parent_id','=', 1);
            })->get();
        }

        if($slug == 'shop')
        {
            $records =  Product::with('ProductImage')->get();
        }
        
        return view('Frontend.pages.shop')->with(compact('records'));
    }

    public function product($slug)
    {
        $record = Product::with('ProductImage', 'ProductSpecification')->where('slug', $slug)->get();

        $totalStock = $record[0]->ProductSpecification[0]->xs_quantity + $record[0]->ProductSpecification[0]->s_quantity + $record[0]->ProductSpecification[0]->m_quantity + $record[0]->ProductSpecification[0]->l_quantity
                        + $record[0]->ProductSpecification[0]->xl_quantity + $record[0]->ProductSpecification[0]->xxl_quantity;
                    
        return view('Frontend.pages.product')->with(compact('record', 'totalStock'));   
    }
}