<?php
namespace App\Http\Controllers\Frontend;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
class CartsController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $records = Cart::with('Product')->get();
       
        if($request->method() == 'POST')
        {
            $record = new Cart();
            $record->fill(Input::all());
            $record->Save();
        }

        return view('Frontend.Carts.index')->with(compact('records'));;
    }
    
}