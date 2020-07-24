<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Payments;
use App\Orders;
use App\Customers;
use App\OrderItem;

use App\Http\Controllers\Midtrans\Config;
use App\Http\Controllers\Midtrans\Transaction;

use App\Http\Controllers\Midtrans\ApiRequestor;
use App\Http\Controllers\Midtrans\CoreApi;
use App\Http\Controllers\Midtrans\Notification;
use App\Http\Controllers\Midtrans\Snap;
use App\Http\Controllers\Midtrans\SnapApiRequestor;

use App\Http\Controllers\Midtrans\Sanitizer;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function get_data_product($order_id){
        $data = OrderItem::where('order_id', $order_id)->with(array('product' => function($query){
            $query->select();
        }))->get();

        return $data;
    }
    public function get_data_customer($order_id)
    {
        $orders = Orders::find($order_id);
        $customer = Customers::find($orders->user_id);

        return $customer;
    }
    public function create(Request $request){
        Config::$serverKey = 'SB-Mid-server-LBSeRtvEqCxUw5MTtMBpCLBd';
        if(!isset(Config::$serverKey))
        {
            return "Please set your payment server key";
        }

        Config::$isSanitized = true;
        Config::$is3ds = true;

        $product_list = [];
        $product_order = $this->get_data_product(3);
        // return $product_order[1]['product']['price'];
        for($i=0; $i < count($product_order); $i++)
        {
            $product_list['id'] = $product_order[0]['id'];
            $product_list['price'] = $product_order[0]['product']['price'];
            $product_list['quantity'] = $product_order[0]['quantity'];
            $product_list['name'] = $product_order[0]['product']['name'];
        }
        // return $product_list;

        $customer_details = $this->get_data_customer(1);
        $customer_details = array(
            'first_name'    => $customer_details->fullname,
            'last_name'     => "",
            'email'         => $customer_details->email,
            'phone'         => $customer_details->phone_number
        );
        // $item_list[] = [
        //     'id' => "222",
        //     'price' => 30000,
        //     'quantity' => 2,
        //     'name' => "Ayam Geprek"
        // ];

        // $transaction_details = array(
        //     'order_id' => rand(),
        //     'gross_amount' => 20000, // no decimal allowed for creditcard
        // );

        // $customer_details = array(
        //     'first_name'    => "Abi",
        //     'last_name'     => "Mulya",
        //     'email'         => "abimulya.2001@gmail.com",
        //     'phone'         => "081122334455",
        // );
        // {
        //     "data": {
        //       "attributes": {
        //       "payment_type": "bank_transfer",
        //       "gross_amount": 20000,
        //       "bank": "bni",
        //       "order_id": 1
        //       }
        //     }
        //   }
        $transaction = array(
            // 'enabled_payments' => $enable_payments,
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_list,
        );

        try {
            $snapToken = Snap::createTransaction($transaction);
            return response()->json(['code' => 1 , 'message' => 'success' , 'result' => $snapToken]);
            // return ['code' => 1 , 'message' => 'success' , 'result' => $snapToken];
        } catch (\Exception $e) {
            dd($e);
            return ['code' => 0 , 'message' => 'failed'];
        }
    }
}
