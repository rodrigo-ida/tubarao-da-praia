<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Complement extends Model
{
    protected $table = "product_complements";

    protected $fillable = [
        'complement_pic_src',
        'name_complement',
        'price_complement',
        'category_id',
        'complements_status'
    ];

    static public $images_storage_path = 'media/product/complements';

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

        $updateRules['name_complement'] = 'required';
        $updateRules['price_complement'] = 'required';
        $updateRules['category_id'] = 'required';

        return $updateRules;
    }

    private function validationRules()
    {
        return [
            'name_complement' => 'required|min:1',
            'price_complement' => 'required|min:1',
            'category_id' => 'required',
        ];
    }

    public function productCategories()
    {
        return $this->hasOne(ProductCategories::class, 'id', 'category_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
