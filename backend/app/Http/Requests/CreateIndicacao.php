<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateIndicacao extends FormRequest
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
    public static function rules()
    {
        return [
            'nome'      => 'required|string|max:220',
            'cpf'       => 'required|string|max:11',
            'telefone'  => 'required|string|max:15',
            'email'     => 'required|string|email|max:255'
        ];
    }

    /**
     * Get the messages that apply to the response
     * 
     * @return array
     */
    public static function messages() 
    {
        return [
            'required'  => 'O campo :atrribute deve ser preenchido',
            'string'    => 'O campo :attribute deve ser uma string',
            'email'     => 'O campo :attribute deve ser um email válido',
            'max'       => 'O campo :attribute não pode ser maior que :max caracteres'
        ];
    }
}
