<?php

namespace App;

use App\Contracts\Services\ClientService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use RandomLib\Factory;
use RandomLib\Generator;
use OCP\Security\ISecureRandom;

class Client extends Authenticable
{

    protected $fillable = [
        'nome',
        'email',
        'whatsapp',
        'cep',
        'estado',
        'cidade',
        'logradouro',
        'bairro',
        'numero',
        'complemento',
        'data_nasc',
        'sexo',
        'login_token',
        'origem',
        'sobrenome'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'data_nasc'
    ];


    /**
     * @var Generator
     */
    private $generator;

    /**
     * @var \Illuminate\Validation\Validator
     */
    private $validator;

    public function __construct(array $attributes = [])
    { 
        parent::__construct($attributes);
        $this->generator = (new Factory)->getLowStrengthGenerator();
        //$this->generator = $this->secureRandom->generate(64);
        $this->validator = Validator::make([],[]);
    }

    public function couponValidations()
    {
        return $this->hasMany(Coupon::class);
    }

    public function resetLoginToken(ClientService $service)
    {
        $token = $service->generateUniqueLoginToken();
        $this->login_token = $token;
    }

    public function getDataNascAttribute($value)
    {
        if ($value === '0000-00-00 00:00:00' || $value === '0000-00-00' || $value == '00:00:00' || $value === null) {
            return null;
        }
        if (!is_string($value)) {
            return Carbon::parse($value)->format('d/m/Y');
        }
        $date = Carbon::parse($value)->format('d/m/Y');
        return $this->attributes['data_nasc'] = Carbon::createFromFormat('d/m/Y', $date);
    }

    /**
     * @param $value string representing a valid date
     * @return null|static
     */
    public function setDataNascAttribute($value)
    {
        // TODO: verificar se quando o parâmetro for diferente de string ele pode ser usado
        // caso contrário, incluir a verificação de parâmetro como argumento inválido
        // antes de implementar, favor adicionar um Test Case
        // if (!is_string($value)) {
        //     return null;
        // }

        if ($value != null) {
            $newDate = \DateTime::createFromFormat('d/m/Y', $value);
            /**
             * Necessário pois o seeder utiliza desta maneira
             */
            if ($newDate === FALSE) {
                $newDate = \DateTime::createFromFormat('Y-m-d', $value);
            }

            if ($newDate !== FALSE) {
                $value = Carbon::instance($newDate);
                $this->attributes['data_nasc'] = $value;
            }

        }

        // TODO: verificar se é necessário retornar esse valor

        return $value;
    }

    /**
     * Verify if this Client is valid
     * @param bool $new true for new Client or false to validate a persisted Client
     * @return bool true if valid
     */
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

    /**
     * @return \Illuminate\Validation\Validator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    private function updateValidationRules()
    {
        $updateRules = Client::validationRules();
        $updateRules['whatsapp'] = 'required|unique:clients,whatsapp,' . $this->id;
        $updateRules['email']    = 'required|email|unique:clients,email,' . $this->id;
        return $updateRules;
    }

    private function validationRules()
    {
        return [
            'nome'        => 'required|max:191|min:3',
            'whatsapp'    => 'required|unique:clients,whatsapp',
            'email'       => 'required|email|unique:clients,email',
            'cep'         => 'required',
            'estado'      => 'required',
            'cidade'      => 'required',
            'bairro'      => 'required',
            'logradouro'  => 'required',
            'numero'      => 'required',
            'complemento' => 'max:191',
            'data_nasc'   => 'required|date',
            'sexo'        => 'required|in:Masculino,Feminino',
        ];
    }

}
