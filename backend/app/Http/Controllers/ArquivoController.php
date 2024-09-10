<?php

namespace App\Http\Controllers;

use App\Exports\UsuarioExport;
use App\Http\Resources\UsuarioExportResource;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;

class ArquivoController extends Controller
{
    public function index(Request $request) {
        if($request->type == 'csv'){
            $extencao = 'csv';
            $formato = \Maatwebsite\Excel\Excel::CSV;
            return $this->geradorDoc($formato, $extencao);
        } else if($request->type == 'xls'){
            $extencao = 'xls';
            $formato = \Maatwebsite\Excel\Excel::XLS;
            return $this->geradorDoc($formato, $extencao);
        } else if($request->type == 'pdf'){
            return $this->geradorPdf();
        }
    }

    private function geradorDoc($formato, $extencao){
        $arquivo = Uuid::uuid4().".".$extencao;
        return Excel::download(new UsuarioExport, $arquivo, $formato);
    }

    private function geradorPdf(){
        $usuarios = UsuarioExportResource::collection(Usuario::latest()->where('status', 'ativo')->get());
        $pdf = Pdf::loadView('pdf.pdf', compact('usuarios'));
        return $pdf->download(Uuid::uuid4().'.pdf');
    }
}
