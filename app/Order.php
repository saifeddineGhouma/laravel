<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function getTotalAttribute()
    {
     return  $this->orderItems->sum(function($item){
                    return $item->price * $item->quantity ;
                });

    }
}
