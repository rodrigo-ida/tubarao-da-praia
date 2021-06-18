<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;

class ProductVariation extends Model
{
    protected $table    = 'product_variation';

    protected $fillable = 
    [
        'prod_var_name',

        'prod_id',

        'prod_var_price',

        'prod_var_active',

        'prod_var_status',

        'prod_var_promo_price',

        'prod_var_promo_day'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
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

        $updateRules['prod_var_name']        = 'required';
        $updateRules['prod_id']              = 'required';
        $updateRules['prod_var_price']       = 'required';
        $updateRules['prod_var_active']      = 'required';
        $updateRules['prod_var_status']      = 'required';
        $updateRules['prod_var_promo_day']   = 'required';
        $updateRules['prod_var_promo_price'] = 'required';

        return $updateRules;
    }
   
    private function validationRules()
    {
        return [
            'prod_var_name'         => 'required',
            'prod_id'               => 'required',
            'prod_var_price'        => 'required',
            'prod_var_active'       => 'required',
            'prod_var_status'       => 'required',
            'prod_var_promo_day'    => 'required',
            'prod_var_promo_price'  => 'required'
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, 'id', 'prod_id');
    }

    public function getLoja()
    {
        return $this->hasOne(Loja::class, 'id', 'promo_banner_loja_id');
    }

    // public function getPromotion()
    // {
    //     return $this->hasOne(ProductPromotion::class, 'id', 'prod_var_promo_id');
    // }

}
