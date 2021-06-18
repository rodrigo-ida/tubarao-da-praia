<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Loja extends Model
{

    const LOJA_DESATIVADA = 0;

    const LOJA_ATIVA = 1;

    protected $table = 'loja';

    protected $fillable = [
        'nome_loja',
        'whatsapp_loja',
        'telefone_loja',
        'email_loja',
        'cep_loja',
        'estado_loja',
        'cidade_loja',
        'bairro_loja',
        'logradouro_loja',
        'numero_loja',
        'facebook_loja',
        'site_loja',
        'status',
        'loja_pic_src'
    ];

    static $images_storage_path = 'media/loja';

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

        $updateRules['nome_loja'] = 'required';
        $updateRules['cep_loja'] = 'required';
        $updateRules['estado_loja'] = 'required';
        $updateRules['cidade_loja'] = 'required';
        $updateRules['bairro_loja'] = 'required';
        $updateRules['logradouro_loja'] = 'required';
        $updateRules['numero_loja'] = 'required';

        return $updateRules;
    }

    private function validationRules()
    {
        return [
            'nome_loja' => 'required|min:1',
            'whatsapp_loja' => 'nullable|min:11',
            'telefone_loja' => 'nullable|min:10',
            'email_loja' => 'nullable|email',
            'cep_loja' => 'required|min:8|max:9',
            'estado_loja' => 'required',
            'cidade_loja' => 'required',
            'bairro_loja' => 'required',
            'logradouro_loja' => 'required',
            'numero_loja' => 'required',
        ];
    }

    public function hasImage()
    {

        return $this->loja_pic_src && !empty($this->loja_pic_src);
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

        return self::$images_storage_path . '/' . $this->loja_pic_src;
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
}
