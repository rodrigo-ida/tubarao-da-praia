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

    const ROLE_LOJA  = 0;

    const ROLE_ADMIN = 1;

    const ROLE_USER  = 2;

    const ROLE_DELIVERYMAN = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'loja_id', 'client_id', 'deliveryman_online'
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
        $this->validator = Validator::make([], []);
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
            'password'  => 'required',
            'role'      => 'required',
            'loja_id'   => 'required'
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

    public function getLoja()
    {
        return $this->hasOne(Loja::class, 'id', 'loja_id');
    }

    public function getDeliveryManOrders()
    {
        return $this->hasMany(Order::class, 'deliveryman_id', 'id')->whereIn('order_status', ['5', '7'])->orderBy('updated_at', 'DESC');
    }

    public function getDeliveryManTime()
    {
        return $this->hasMany(DeliverymanTime::class, 'deliveryman_id', 'id')->where('updated_at', '!=', null);
    }

    public function authorizeRoles($roles)
    {
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(401, 'This action is unauthorized.');
    }
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }
    public function hasRole($role)
    {
        if ($this->role == $role) {
            return true;
        }
        return false;
    }

    public function roles()
    {
        return [
            'ROLE_LOJA' => 0,
            'ROLE_ADMIN' => 1,
            'ROLE_USER' => 2,
            'ROLE_DELIVERYMAN' => 3,
        ];
    }
}
