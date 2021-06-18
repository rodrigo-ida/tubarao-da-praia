<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;

use App\Client;

class Avaliation extends Model
{
    protected $table    = 'avaliation';

    protected $fillable = 
    [
        'avaliation_note',
        'avaliation_desc',
        'client_id',
        'token',
        'avaliation_status',
        'order_id'
    ];

    public function getClient()
    {
        $this->hasOne(Client::class, 'id', 'client_id');
    }

}
