<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderUpdatedStatusTime extends Model
{
    protected $table = "order_update_status_time";

    protected $fillable = [
        'order_status_updated_id',
        'order_user_updated_id',
        'order_status_name',
        'created_at',
        'updated_at'
    ];

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'order_user_updated_id');
    }
}
