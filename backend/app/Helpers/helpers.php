<?php

use Illuminate\Support\Carbon;

function formatarDataPtBr($data) {
    return Carbon::createFromFormat('Y-m-d', $data)->format('d/m/Y');
}

function formatarCpf($cpf) {
    return substr($cpf, 0, 3).'.'.substr($cpf, 3, 3).'.'.substr($cpf, 6, 3).'-'.substr($cpf,9,2);
}

function formatarTelefone($telefone) {
    return '('.substr($telefone, 0, 2).") ".substr($telefone, 2, 5)."-".substr($telefone, 6, 5);
}

function formatarCep($cep) {
    return substr($cep, 0, 5).'-'.substr($cep, 5, 3);
}

function removerCaracteresNaoNumericos($dado) {
    return preg_replace("/[^0-9]/", "", $dado);
}
