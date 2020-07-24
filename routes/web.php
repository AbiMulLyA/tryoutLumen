<?php
use Illuminate\Http\Response;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $router->group(['middleware' => 'auth'], function () use ($router) {
//     $router->get("/coba", "MidtransController@getSnapToken");


// });
$router->get('/', function () use ($router) {
    return "Sedang Masa Pengembangan";
});
$router->group(['middleware'=>'auth'], function() use ($router){
    $router->group(['prefix'=> 'api/v1'], function() use ($router){
        $router->get("/coba", "MidtransController@getSnapToken");
        $router->get('customer','CustomerController@getAll');
        $router->get('customer/{id}','CustomerController@getCustomerById');
        $router->post('customer', 'CustomerController@create');
        $router->put('customer/{id}', 'CustomerController@put'); 
        $router->delete('customer/{id}', 'CustomerController@delete');

        $router->get('product','ProductController@getAll');
        $router->get('product/{id}','ProductController@getProductById');
        $router->post('product', 'ProductController@create');
        $router->put('product/{id}', 'ProductController@put'); 
        $router->delete('product/{id}', 'ProductController@delete');

        $router->get('order','orderController@getAll');
        $router->get('order/{id}','orderController@getorderById');
        $router->post('order', 'orderController@create');
        $router->put('order/{id}', 'orderController@put'); 
        $router->delete('order/{id}', 'orderController@delete'); 
    
        $router->post('payment','PaymentController@create');
        // $router->get('post/all','PostController@getAll');
        // $router->get('post/{id}','PostController@getDataByPostId');
        // $router->post('post', 'PostController@create');
        // $router->patch('post/{id}', 'PostController@patch');
        // $router->delete('post/{id}', 'PostController@delete');
    
        // $router->get('comment','CommentController@getDataComment');
        // $router->get('comment/all','CommentController@getAll');
        // $router->get('comment/{id}','CommentController@getDataByCommentId');
        // $router->post('comment', 'CommentController@create');
        // $router->patch('comment/{id}', 'CommentController@patch');
        // $router->delete('comment/{id}', 'CommentController@delete');
    });
});
?>