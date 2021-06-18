<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'titulo' => 'required',
            'descricao' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif|max:1024',
            'coupon_limit' => 'required|numeric|min:0'
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'O campo título é obrigatório',
            'descricao.required'  => 'O campo descrição é obrigatório',
            'image.required'  => 'O campo imagem é obrigatório',
            'image.mimes'  => 'O campo imagem deve conter um arquivo de imagem (jpeg, png, jpg ou gif)',
            'image.max'  => 'A imagem pode ter no máximo 1024 kilobytes',
            'coupon_limit.required'  => 'O campo limite de cupons é obrigatório',
            'coupon_limit.numeric'  => 'O campo limite de cupons deve ser um número',
            'coupon_limit.min'  => 'O campo limite de cupons deve ser maior ou igual a 0 (zero)',
        ];
    }
}
