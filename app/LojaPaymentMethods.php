<?php



namespace App;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;



class LojaPaymentMethods extends Model

{

    protected $table = "payment_methods_loja";



    protected $fillable = [

        'id',

        'payment_method_loja_id',

        'payment_method_ids'

    ];



    private $validator;



    public function __construct(array $attributes = [])

    {

        $this->validator = Validator::make([], []);

    }





    public function getLojas()

    {

        return $this->hasOne(Loja::class, 'id', 'payment_method_loja_id');

    }



    public function getPaymentMethods()

    {

        return $this->hasMany(PaymentMethod::class, 'id', 'payment_method_ids');

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

        $updateRules['payment_method_loja_id'] = 'required';
        $updateRules['payment_method_ids'] = 'required';

        return $updateRules;

    }

    private function validationRules()
    {

        return [

            'payment_method_loja_id' => 'required',
            'payment_method_ids' => 'required',

        ];
    }
}   