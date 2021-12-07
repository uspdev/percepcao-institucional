<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
            'dataAbertura'                      => 'required',
            'dataFechamento'                    => 'required',
            'totalAlunosMatriculados'           => 'nullable',
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT') {
            array_push($rules['liberaConsultaMembrosEspeciais'], ['required', Rule::in(Percepcao::simNao())]);
            array_push($rules['liberaConsultaDocente'], ['required', Rule::in(Percepcao::simNao())]);
            array_push($rules['liberaConsultaAluno'], ['required', Rule::in(Percepcao::simNao())]);
        }

        return $rules;
    }
}
