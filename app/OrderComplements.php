<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderComplements extends Model
{
    protected $table    = 'order_complements';

    protected $fillable = [
        'id_prod', 
        'id_comp',
        'price_comp',
        'qtd_comp',
        'order_id',
        'order_product_id'
    ];

    public function getOrderVariableProducts()
    {
        return $this->hasMany(Product::class, 'id', 'id_prod');
    }

    public function getComplement()
    {
        return $this->hasOne(Complement::class, 'id', 'id_comp');
    }
}
