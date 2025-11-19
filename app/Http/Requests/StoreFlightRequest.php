<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFlightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'departure_airport_id' => ['required', 'integer', 'exists:airports,id'],
            'arrival_airport_id' => [
                'required',
                'integer',
                'exists:airports,id',
                'different:departure_airport_id',
            ],
            'departure_time' => ['required', 'date', 'after:now'],
            'arrival_time' => ['required', 'date', 'after:departure_time'],
        ];
    }

    public function messages(): array
    {
        return [
            'departure_airport_id.required' => 'O aeroporto de partida é obrigatório',
            'departure_airport_id.exists' => 'O aeroporto de partida selecionado não existe',
            'arrival_airport_id.required' => 'O aeroporto de chegada é obrigatório',
            'arrival_airport_id.exists' => 'O aeroporto de chegada selecionado não existe',
            'arrival_airport_id.different' => 'Os aeroportos de partida e chegada devem ser diferentes',
            'departure_time.required' => 'O horário de partida é obrigatório',
            'departure_time.date' => 'O horário de partida deve ser uma data válida',
            'departure_time.after' => 'O horário de partida deve ser no futuro',
            'arrival_time.required' => 'O horário de chegada é obrigatório',
            'arrival_time.date' => 'O horário de chegada deve ser uma data válida',
            'arrival_time.after' => 'O horário de chegada deve ser após o horário de partida',
        ];
    }
}
