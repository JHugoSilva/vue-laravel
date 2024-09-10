<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CPF implements ValidationRule
{
    private function validar($cpf){

        //QUALQUER VALOR QUE NÃO SEJA NUMÉRICO SERÁ EXCLUÍDO
        $cpf = removerCaracteresNaoNumericos($cpf);

        //VERIFICA SE POSSUI ONZE CARACTERES
        if (strlen($cpf) != 11) {
            return false;
        }

        $validaDigitoUm = 0;
        $validaDigitoDois = 0;

        for ($i = 0, $x = 10; $i <= 8; $i++, $x--) {
            $validaDigitoUm += $cpf[$i] * $x;
        }

        for ($i = 0, $x = 11; $i <= 9; $i++, $x--){
            if (str_repeat($i, 11) == $cpf) {
                return false;
            }
            $validaDigitoDois += $cpf[$i] * $x;
        }

        $resultadoUm = (($validaDigitoUm % 11) < 2) ? 0 : 11 - ($validaDigitoUm % 11);
        $resultadoDois = (($validaDigitoDois % 11) < 2) ? 0: 11- ($validaDigitoDois % 11);

        if ($resultadoUm != $cpf[9] || $resultadoDois != $cpf[10]) {
            return false;
        }
            return true;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->validar($value)) {
            $fail("O campo $attribute não e um CPF válido");
        }
    }
}
