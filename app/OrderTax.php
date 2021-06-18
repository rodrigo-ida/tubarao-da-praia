<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;

use App\DeliveryConfig;

class OrderTax extends Model
{

    const OrderTaxActive   = 1;

    const OrdertaxDeactive = 0;

    protected $table    = "order_tax";

    protected $fillable = [

        'order_tax_cep_inicial',

        'order_tax_cep_final',

        'order_tax_status',

        'order_tax_loja_id',

        'order_tax_neighborhood',

        'order_tax_price',

        'created_at',

        'updated_at',

        'order_shipping_time'

    ];

    private $validator;

    public function __construct(array $attributes = [])
    {

        $this->validator = Validator::make([], []);
    }

    public function getDeliveryConfig()
    {
        return $this->hasMany(DeliveryConfig::class, 'config_loja_id', 'order_tax_loja_id');
    }

    public function getLoja()
    {

        return $this->hasOne(Loja::class, 'id', 'order_tax_loja_id');
    }

    public function getLojas()
    {

        return $this->hasMany(Loja::class, 'id', 'order_tax_loja_id');
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

        $updateRules['order_tax_cep_inicial']  = 'required|min:1|max:8';

        $updateRules['order_tax_cep_final']    = 'required|min:1|max:8';

        $updateRules['order_tax_status']       = 'required';

        $updateRules['order_tax_neighborhood'] = 'required';

        $updateRules['order_tax_loja_id']      = 'required';

        $updateRules['order_shipping_time']    = 'required|date_format:H:i';

        return $updateRules;
    }

    private function validationRules()
    {

        return [

            'order_tax_cep_inicial'  => 'required|min:1|max:8',

            'order_tax_cep_final'    => 'required|min:1|max:8',

            'order_tax_status'       => 'required',

            'order_tax_neighborhood' => 'required',

            'order_tax_loja_id'      => 'required',

            'order_shipping_time'    => 'required|date_format:H:i'

        ];
    }
}
