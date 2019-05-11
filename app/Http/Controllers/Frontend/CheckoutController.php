<?php
namespace App\Http\Controllers\Frontend;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use Stripe;

class CheckoutController extends \App\Http\Controllers\Controller
{
    /**
     * Open Checkout Page
     */
    public function index()
    {
        if(Auth::check())
        {
            $records = Cart::with('Product')->where('user_id', Auth::user()->id)->get();
        }
        return view('Frontend.Checkout.index')->with(compact('records'));
    }

    /**
     * open payment popup
     */
    public function paymentPopup()
    {
        return view('Frontend.Checkout.popup');
    }

    /**
     * process stripe payment
     */
    public function processStripePayment(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "INR",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);
  
        Session::flash('success', 'Payment successful!');
        return back();
    }

}