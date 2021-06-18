<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForgotPassword extends Model
{
    protected $table = 'forgot_password';

    protected $fillable = [
        'client_id',
        'reset_token',
        'status',
        'reset_code'
    ];

    public function getClient()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }
}
