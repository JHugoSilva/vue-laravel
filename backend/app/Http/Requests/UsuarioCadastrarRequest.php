<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use App\Rules\CPF;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class UsuarioCadastrarRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|min:3',
            'cpf' => ['required', Rule::unique(Usuario::class,'cpf'), new CPF],
            'data_nascimento' => 'required|date|after:-100 years|date_format:Y-m-d|before_or_equal:today',
            'email' => ['required','email', Rule::unique(Usuario::class,'email')],
            'telefone' => 'required',
            'cep' => 'required',
            'estado' => 'required',
            'bairro' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
        ];
    }

    public function messages() {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'O campo :attribute já está cadastrado.',
            'data_nascimento.date' => 'O campo :attribute deve ser do tipo data.',
            'data_nascimento.after' => 'O campo :attribute não deve ser superior a (100 anos).',
            'data_nascimento.before_or_equal' => 'O campo :attribute não pode ser maior que o dia de hoje.',
            'email.email' => 'O campo :attribute deve ser do tipo email.',
        ];
    }

    public function getData() {
        $data = $this->validated();
        $data['cpf'] = removerCaracteresNaoNumericos($data["cpf"]);
        $data['telefone'] = removerCaracteresNaoNumericos($data["telefone"]);
        $data['cep'] = removerCaracteresNaoNumericos($data["cep"]);
        $data['endereco'] = $data['endereco'].', '.$data['numero'];
        unset($data['numero']);
        return $data;
    }
}
