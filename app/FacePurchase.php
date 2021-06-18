<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;

use App\DeliveryConfig;

class FacePurchase extends Model
{

    protected $table    = "face_purchase";

    protected $fillable = [

        'product_id',

        'user_id',
        
     

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

        $updateRules['status']  = 'required';

        $updateRules['user_id']    = 'required';

      

        return $updateRules;
    }

    private function validationRules()
    {

        return [

            'status'  => 'required',

            'user_id'    => 'required',

            


        ];
    }
}
