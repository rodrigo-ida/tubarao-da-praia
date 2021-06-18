<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class PaymentMethod extends Model
{
    protected $table    = "payment_methods";

    protected $fillable = [
        'id', 'name_method'
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

        $updateRules['name_method'] = 'required';
       
        return $updateRules;
    }
   
    private function validationRules()
    {
        return [
            'name_method' => 'required',
        ];
    }
}
