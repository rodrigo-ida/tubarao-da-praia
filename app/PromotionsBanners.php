<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;

class PromotionsBanners extends Model
{
    protected $table    = 'promotion_banner';

    protected $fillable =
    [
        'promo_banner_pic_src',
        'promo_banner_prod_id',
        'promo_banner_day',
        'promo_banner_loja_id',
        'promo_banner_home'
    ];

    static public $images_storage_path = 'media/banner';

    private $validator;

    public function __construct(array $attributes = [])
    {
        $this->validator = Validator::make([], []);
    }

    public function hasImage()
    {

        return $this->promo_banner_pic_src && !empty($this->promo_banner_pic_src);
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

        return self::$images_storage_path . '/' . $this->promo_banner_pic_src;
    }

    /**

     * Returns the URL of the image or null in case the image_file attribute is not set or empty.

     * Internally, uses hasImage function to verify this question

     * @return string|null

     */

    public function getImageURL()
    {

        return $this->hasImage() ? \Storage::url($this->getImagePath()) : null;

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

        $updateRules['promo_banner_prod_id'] = 'required';
        $updateRules['promo_banner_day']     = 'required';
        $updateRules['promo_banner_loja_id'] = 'required';
        $updateRules['promo_banner_home'] = 'required';

        return $updateRules;
    }

    private function validationRules()
    {
        return [
            'promo_banner_prod_id' => 'required',
            'promo_banner_day'     => 'required',
            'promo_banner_loja_id' => 'required',
            'promo_banner_home' => 'required'
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, 'id', 'promo_banner_prod_id');
    }

    public function getLoja()
    {
        return $this->hasOne(Loja::class, 'id', 'promo_banner_loja_id');
    }
}
