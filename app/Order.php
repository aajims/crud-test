<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $fillable = ['no','date','customer_id','subtotal','discount','total'];

    public function customers(){
    	return $this->belongsTo(Customer::class, 'name');
    }

    public function orderItems()
    {
        return $this->HasMany(OrderItem::class);
    }
}
