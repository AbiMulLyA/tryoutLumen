<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
    protected $table = "orders";
    public function order_item(){
        return $this->hasMany("App\OrderItem");
    }
    public function payment(){
        return $this->hasMany("App\Payment");
    }

    public function customer(){
        return $this->belongsTo("App\Customer");
    }
}
?>