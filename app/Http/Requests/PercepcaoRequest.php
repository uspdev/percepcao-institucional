<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Percepcao;

class PercepcaoRequest extends FormRequest
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
        $rules = [
            'ano'                               => ['required', 'integer'],
            'semestre'                          => ['required', 'integer'],
            'dataDeAbertura'                    => 'required',
            'dataDeFechamento'                  => 'required',
            'totalDeAlunosMatriculados'         => 'nullable',
            'liberaConsultaMembrosEspeciais'    => ['nullable'],
            'liberaConsultaDocente'             => ['nullable'],
            'liberaConsultaAluno'               => ['nullable'],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'simNao.in' => 'O tipo selecionado é inválido.',
        ];
    }
}
