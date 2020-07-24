<?php

namespace App\Http\Controllers;
use App\Order;
use App\OrderItem;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
class OrderController extends Controller
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
    
    public function getAll(){
        $data = Order::all();
        if(!$data){
            return response()->json([
                "Status" => "Data Not Found"
            ]);
        }
        return response()->json([
            "Message" => "success retrieve data",
            "status"=> true,
            "datas" => $data
        ]);
    }
    public function getOrderById($id){
        $data = Order::find($id);
        // $data = Customer::where('id',$id);
        if(!$data){
            return response()->json([
                "Status" => "ID Not Found"
        ]);
        }
        return response()->json([
            "Message" => "success retrieve data",
            "status"=> true,
            "data" => $data
        ]);
    }


    public function create(Request $request){
        $request_order = $request->all();
        $data = new Order();
        $data->user_id = $request_order['data']['attributes']['user_id'];
        $data->order_status = "created";
        $data->save();

        $order_detail = $request_order['data']['attributes']['order_detail'];
        for($i=0; $i<count($order_detail); $i++){
            $data_item = new OrderItem();
            $data_item->order_id = $data->id;
            $data_item->product_id = $order_detail[$i]['product_id'];
            $data_item->quantity = $order_detail[$i]['quantity'];
            $data_item->save();
        }
        return $request;
    }

    // public function put(Request $request, $id){
    //     $data = Order::find($id);
    //     if ($data) {
    //         $data->full_name = $request->input("data.attributes.full_name");
    //         $data->username = $request->input("data.attributes.username");
    //         $data->email = $request->input("data.attributes.email");
    //         $data->phone_number = $request->input("data.attributes.phone_number");
    //         $data->save();

    //         return response()->json([
    //             "Message" => "success retrieve data",
    //             "status"=> true,
    //             "data" => $data
    //         ]);        
    //     }else {
    //         return response()->json([
    //             "status" => "ID Not Found"
    //         ]);
    //     }
    // }
    // public function Delete(Request $request, $id){
    //     $data = Order::find($id);
    //     if($data) {
    //         $data->delete();
    //         return response()->json([
    //             "message" => "Success Deleted",
    //             "status"=> true,
    //             "results" => $data
    //         ]);   
    //     }else {
    //         return response()->json([
    //             "message" => "Parameter Not Found"
    //         ]);
    //     }
    // }
}
