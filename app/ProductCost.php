<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ProductCost extends Model
{
    protected $table = 'product_costs';

    protected $fillable = [
        'product_cost_price', 
        'product_id'   
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

        $updateRules['product_cost_price'] = 'required';
        $updateRules['product_id']         = 'required';
       
        return $updateRules;
    }
   
    private function validationRules()
    {
        return [
            'product_cost_price' => 'required', 
            'product_id'         => 'required'
        ];
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
}
