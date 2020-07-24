<?php

namespace App\Http\Controllers;
use App\Customer;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
class CustomerController extends Controller
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
        $data = Customer::all();
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
    public function getCustomerById($id){
        // $id = Customer::find($id);
        $data = Customer::where('id',$id);
        if(!$data){
            return response()->json([
                "Status" => "ID Not Found"
        ]);
        }
        return response()->json([
            "Message" => "success retrieve data",
            "status"=> true,
            "datas" => $data
        ]);
    }


    public function create(Request $request){
        $data = new Customer();
        $data->full_name = $request->input("full_name");
        $data->username = $request->input("username");
        $data->email = $request->input("email");
        $data->phone_number = $request->input("phone_number");
        $data->save();

        return response()->json([
            "Message" => "success retrieve data",
            "status"=> true,
            "data"=> $data
        ]);
    }

    public function put(Request $request, $id){
        $data = Customer::find($id);
        if ($data) {
            $data->full_name = $request->input("full_name");
            $data->username = $request->input("username");
            $data->email = $request->input("email");
            $data->phone_number = $request->input("phone_number");
            $data->save();

            return response()->json([
                "Message" => "success retrieve data",
                "status"=> true,
                "datas" => $data
            ]);        
        }else {
            return response()->json([
                "status" => "ID Not Found"
            ]);
        }
    }
    public function Delete(Request $request, $id){
        $data = Customer::find($id);
        if($data) {
            $data->delete();
            return response()->json([
                "message" => "Success Deleted",
                "status"=> true,
                "results" => $data
            ]);   
        }else {
            return response()->json([
                "message" => "Parameter Not Found"
            ]);
        }
    }
}
