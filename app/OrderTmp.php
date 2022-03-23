<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTmp extends Model
{
    protected $table = 'order_tmp';
    protected $fillable = ['item','qty','price','total'];
}
