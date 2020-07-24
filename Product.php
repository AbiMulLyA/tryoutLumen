<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    protected $table = "products";
    public function order_item(){
        return $this->hasMany("App\OrderItem");
    }
}
?>