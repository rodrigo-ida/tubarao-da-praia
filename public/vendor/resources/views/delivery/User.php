<?php

namespace App;

use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use App\Loja;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_LOJA  = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'loja_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    private $validator;

    public function __construct(array $attributes = [])
    {
        $this->validator = Validator::make([],[]);
    }

    public function validate($new = true)
    {
        // create a new Validator, as we need a fresh $validate->failed() errors on each call to validate()
        // for specific rule error check
        $rules = $new ? $this->validationRules() : $this->updateValidationRules();
        $this->validator = Validator::make($this->attributes, $rules);

        return !$this->validator->fails();
    }

    /**
     * Validator errors
     * @return MessageBag
     */
    public function getErrors()
    {
        return $this->validator->errors();
    }

    private function updateValidationRules()
    {
        $updateRules = $this->validationRules();

        $updateRules['name']     = 'required';
        $updateRules['email']    = 'required';
        $updateRules['password'] = 'required';
        $updateRules['role']     = 'required';
        $updateRules['loja_id']  = 'required';
       
        return $updateRules;
    }
   
    private function validationRules()
    {
        return [
            'name'      => 'required',
            'email'     => 'required|email',
            'senha'     => 'required',
            'role'      => 'required',
            'loja_Id'   => 'required'
        ];
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function getLojas()
    {
        return $this->belongsTo(Loja::class, 'id_loja');
    }
}
