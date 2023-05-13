<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RotasStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "nome_trajeto" => 'required|string',
            "data_viagem" => 'required|date',
            "partida_nome" => 'required|string',
            "partida_endereco" => 'required|string',
            "partida_longitude" => 'required|string',
            "partida_latitude" => 'required|string',
            "destino_nome" => 'required|string',
            "destino_endereco" => 'required|string',
            "destino_longitude" => 'required|string',
            "destino_latitude" => 'required|string'
        ];
    }

    public function messages()
    {
        return[
            'nome_trajeto.required' => 'Nome do trajeto é obrigatório',
            'data_viagem.required' => 'Data de Vítima é obrigatória',
            'partida_nome.required' => 'Nome da partida é obrigatória',
            'partida_endereco.required' => 'Endereço de partida é obrigatória',
            'partida_longitude.required' => 'Longitude é obrigatória',
            'partida_latitude.required' => 'Latitude é obrigatória',
            'destino_nome.required' => 'Nome da destino é obrigatória',
        ];
    }
}
