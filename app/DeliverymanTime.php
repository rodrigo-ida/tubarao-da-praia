<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliverymanTime extends Model
{
    protected $table = 'deliveryman_time';

    protected $fillable = [
        'lat',
        'lng',
        'order_id',
        'deliveryman_id',
    ];

    public function getDeliveryMan()
    {
        return $this->hasOne(User::class, 'id', 'deliveryman_id');
    }

    public function getOrder()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function getOrders()
    {
        return $this->hasMany(Order::class, 'deliveryman_id', 'deliveryman_id')->where('order_status', '=', '5');
    }
}
