<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;

class ComboVariation extends Model
{
    protected $table = 'combo_variation';

    protected $fillable = [
        'cat_id',
        'variation_name',
        'refer_product',
        'num_esc',
        'created_at',
        'prod_id',
        'updated_at'
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

    public function getComboCategory()
    {
        return $this->hasOne(ProductCategories::class, 'id', 'cat_id');
    }

    private function updateValidationRules()
    {

        $updateRules = $this->validationRules();

        $updateRules['cat_id'] = 'required';

        $updateRules['variation_name'] = 'required';

        $updateRules['num_esc'] = 'required';

        return $updateRules;
    }

    private function validationRules()
    {

        return [

            'cat_id' => 'int|required',

            'variation_name' => 'required',

            'num_esc' => 'int|required',

        ];
    }

    public function getCategory()
    {
        return $this->hasOne(ProductCategories::class, 'id', 'cat_id');
    }
}
