<?php
namespace App\Http\Controllers\Frontend;
use App\Models\Order;
use App\Models\OrderDetail;
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
use Exception;

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
        $amount = Cart::where('user_id', Auth::user()->id)->sum('price');
        return view('Frontend.Checkout.popup')->with((compact('amount')));
    }

    /**
     * process stripe payment
     */
    public function processStripePayment(Request $request)
    {
        $amount = Cart::where('user_id', Auth::user()->id)->sum('price');

        try
        {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $response = Stripe\Charge::create ([
                "amount" => $amount * 100,
                "currency" => "INR",
                "source" => $request->stripeToken,
                "description" => "Shopping payment." 
            ]);

            if($response->captured && $response->status == STRIPE_PAYMENT_SUCCESS)
            {
                $this->_createOrder();
            }
        }
        catch(Exception $e)
        {

        }
        
  
        Session::flash('success', 'Payment successful!');
        return back();
    }

    /**
     * enteries in order and order details table
     */
    private function _createOrder()
    {
        $records = Cart::where('user_id', Auth::user()->id)->get();
        $sum = Cart::where('user_id', Auth::user()->id)->sum('price');

        //create order
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->status = ORDER_PLACED;
        $order->amount = $sum;
        if($order->save())
        {
            foreach($records as $record)
            {
                //create order detail
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $record->product_id;
                $orderDetail->size = $record->size;
                $orderDetail->quantity = $record->quantity;
                $orderDetail->amount = $record->price;
                $orderDetail->save();

                //At end delete record from cart
                $record->delete();
            }
        }
    }
}