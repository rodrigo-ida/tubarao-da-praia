<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\ProductVariation;

class OrderProduct extends Model
{
    protected $table = "order_products";

    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'order_product_price',
        'order_product_total',
        'order_product_qtd',
        'order_combo_ids',
        'order_products_var_id',
        'order_product_combo_id'
    ];

    public function getOrderProducts()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }

    public function getVariations()
    {
        return $this->hasOne(ProductVariation::class, 'id', 'order_products_var_id');
    }
}
