<?php

namespace App\Exports;

use App\Http\Resources\UsuarioExportResource;


use App\Models\Usuario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class UsuarioExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $usuarios = UsuarioExportResource::collection(Usuario::latest()->where('status', 'ativo')->get());
        return $usuarios;
    }

    public function headings(): array
    {
        return [
            'ID',
            'NOME',
            'CPF',
            'DATA NASCIMENTO',
            'E-MAIL',
            'TELEFONE',
            'CEP',
            'ESTADO',
            'BAIRRO',
            'ENDEREÇO',
            'STATUS'
        ];
    }
}
