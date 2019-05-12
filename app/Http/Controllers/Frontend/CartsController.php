<?php
namespace App\Http\Controllers\Frontend;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartsController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
       
    //      $value = $request->session()->get('cart');
    //    dd($value);
        if(Auth::check())
        {
            $records = Cart::with('Product')->where('user_id', Auth::user()->id)->get();
        }
         
        return view('Frontend.Carts.index')->with(compact('records'));
    }
    
    /**
     * add to cart
     */
    public function addToCart(Request $request)
    {
        //request is post
        if($request->method() == 'POST')
        {
            //if auth is set
            if(Auth::check())
            {
                //check if product is already in cart
                $productInCart = Cart::where('product_id', $request->product_id)
                                ->where('user_id',Auth::user()->id)
                                ->where('size',$request->size)
                                ->get();
                if(!$productInCart->isEmpty())
                {
                    $product = Product::find($productInCart[0]->product_id);
                    $productInCart[0]->quantity = $productInCart[0]->quantity + $request->quantity;
                    $productInCart[0]->price = $productInCart[0]->quantity * $product->price;
                    $productInCart[0]->save();

                    return response(['status' => 1, 'data' => 'Quantity updated']);
                }
                
                $record = new Cart();
                $record->fill(Input::all());
                $record->user_id = Auth::user()->id;
                $record->save();
            }
            else //set the cart in session
            {
                Session::put('cart', []);
                Session::push('cart', [
                    'produt_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'size' => $request->size,
                    'price' => $request->price
                ]);
            }
            return response(['status' => 1, 'data' => 'Product added in cart']);
        }
    }

    /**
     * update the cart
     */
    public function updateCart($cartId, $quantity)
    {
        if($quantity == 0)
        {
            Cart::where('id', $cartId)->delete();
            return response(['status' => 1, 'data' => 'Removed from cart.']);
        }

        $cart = Cart::find($cartId);
        $product = Product::find($cart->product_id);

        $cart->quantity = $quantity;
        $cart->price = $quantity * $product->price;
        if(!$cart->save())
        {
            return response(['status' => 0, 'data' => 'Something went wrong.']);
        }

        return response(['status' => 1, 'data' => 'Quantity updated']);
    }
}