<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $fillable = ['code','name'];

    public function orders(){
    	return $this->belongsToMany(Order::class);
    }
}
