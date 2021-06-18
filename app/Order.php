<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DeliveryManTime;
use App\User;

class Order extends Model
{
    protected $table = "orders";

    protected $fillable = [
        'order_total',
        'order_prod_qtd',
        'order_tax_rate',
        'order_street',
        'order_number',
        'order_neighborhood',
        'order_city',
        'order_state',
        'order_complement',
        'order_reference',
        'order_status',
        'order_obs',
        'order_obs_payment',
        'order_payment_method',
        'order_dev_time',
        'order_dev_date',
        'order_client_id',
        'order_loja_id',
        'cpf_nota',
        'order_tax_store',
        'tid_erede',
        'order_client_name',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['order_dev_date'];

    public function getClient()
    {
        return $this->hasOne(Client::class, 'id', 'order_client_id');
    }

    public function userIsAdmin()
    {
        $user = $this->getUser();

        if ($user->count() > 0) {
            if ($user->First()->role == User::ROLE_ADMIN || $user->First()->role == User::ROLE_LOJA) {
                return true;
            }
        }
        return false;
    }

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'order_client_id')->get();
    }

    public function getLoja()
    {
        return $this->hasOne(Loja::class, 'id', 'order_loja_id');
    }

    public function getProducts()
    {
        return $this->hasMany(Product::class, 'order_id', 'id');
    }

    public function getStatus()
    {
        return $this->hasOne(OrderStatus::class, 'id', 'order_status');
    }

    public function getPaymentMethod()
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'order_payment_method');
    }

    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function getOrderComplements()
    {
        return $this->hasMany(OrderComplements::class, 'order_id', 'id');
    }

    public function getDeliveryManObj()
    {
        return $this->hasOne(DeliverymanTime::class, 'order_id', 'id');
    }

    public function getEredeTid()
    {
        return $tid = $this->tid_erede;
    }
}
