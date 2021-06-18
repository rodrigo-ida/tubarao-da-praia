<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ProductCategories extends Model
{

    protected $table = "product_categories";

    static $images_storage_path = 'media/product/category';

    protected $fillable = [
        'name_category', 
        'category_pic_src',
        'category_order'
    ];

    private $validator;

    public function __construct(array $attributes = [])
    {
        $this->validator = Validator::make([],[]);
    }

    public function hasImage()
    {

        return $this->category_pic_src && !empty($this->category_pic_src);

    }

    /**

     * Returns the Path of the image or null in case the image_file attribute is not set or empty.

     * Internally, uses hasImage function to verify this question

     * @return string|null

     */
    public function getImagePath()
    {

        if (!$this->hasImage()) {

            return null;

        }

        return self::$images_storage_path . '/' . $this->category_pic_src;

    }

    /**

     * Returns the URL of the image or null in case the image_file attribute is not set or empty.

     * Internally, uses hasImage function to verify this question

     * @return string|null

     */

    public function getImageURL()
    {

        return $this->hasImage() ? \Storage::url( $this->getImagePath()) : null;

        //return $this->product_pic_src;
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

        $updateRules['name_category'] = 'required';
       
        return $updateRules;
    }
   
    private function validationRules()
    {
        return [
            'name_category' => 'required',
        ];
    }

    public function product() {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function complement() {
        return $this->belongsTo(Complement::class);
    }

}
