<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;

use App\DeliveryConfig;

class Cashier extends Model
{

    protected $table    = "cashier";

    protected $fillable = [

        'valor',

        'acao',
        
        'caixa_status_id',

        'obs',

        'created_at',

        'updated_at',
        
        'face_purchase_id',

        'conta',
        
        'tipo',

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

        $updateRules['valor']  = 'required';

        $updateRules['acao']    = 'required';

        $updateRules['obs']       = 'required';

        $updateRules['caixa_status_id']       = 'required';

        return $updateRules;
    }

    private function validationRules()
    {

        return [

            'valor'  => 'required',

            'acao'    => 'required',

            'obs'       => 'required',

            'caixa_status_id'       => 'required',

        ];
    }
}
