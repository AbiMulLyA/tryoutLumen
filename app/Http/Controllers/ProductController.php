<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
class ProductController extends Controller
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
        $data = Product::all();
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
    public function getProductById($id){
        $data = Product::find($id);
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
        $data = new Product();
        $data->name = $request->input("data.attributes.name");
        $data->price = $request->input("data.attributes.price");
        $data->save();

        return response()->json([
            "Message" => "success retrieve data",
            "status"=> true,
            "data"=> $data
        ]);
    }

    public function put(Request $request, $id){
        $data = Product::find($id);
        if ($data) {
            $data->name = $request->input("name");
            $data->price = $request->input("price");
            $data->save();

            return response()->json([
                "Message" => "success retrieve data",
                "status"=> true,
                "data" => $data
            ]);        
        }else {
            return response()->json([
                "status" => "ID Not Found"
            ]);
        }
    }
    public function Delete(Request $request, $id){
        $data = Product::find($id);
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
