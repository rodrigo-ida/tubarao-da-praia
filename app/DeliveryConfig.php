<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class DeliveryConfig extends Model
{

    protected $table = 'delivery_config';

    protected $fillable = [
        'config_time', 
        'config_time_end',
        'config_date', 
        'config_loja_id', 
        'config_status',
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
        
        return $updateRules;
    }

    private function validationRules()
    {
        return [
        ];
    }

    static public function getHours()
    {
        $total = 96;
        $min  = '00';
        $hora =  '00';
        $date = [ (string)$hora . ":" . $min => '00:00']; 
        
        for($i = 1; $i < $total; $i++)
        {
            if($min == '00')
            {

                $min = '15';
                $date[(string)$hora . ":" . $min] = (string)$hora . ":" . $min; 

            }
            elseif($min == '15')
            {

                $min = '30';
                $date[(string)$hora . ":" . $min] = (string)$hora . ":" . $min;

            }
            elseif($min == '30')
            {

                $min = '45';
                $date[(string)$hora . ":" . $min] = (string)$hora . ":" . $min;

            }
            elseif($min == '45')
            {

                if(intval($hora) <= 8 && $min == '45')
                {

                    $hora++;

                    $hora = '0' . (string)$hora;

                }
                else
                {
                    $hora++;
                }

                $min = '00';

                $date[(string)$hora . ":" . $min] = (string)$hora . ":" . $min;

            }
        }

        return $date;
    }    

    public function getLoja()
    {
        return $this->hasOne(Loja::class, 'id', 'config_loja_id');
    }
}
