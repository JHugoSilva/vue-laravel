<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 15px;
        }

        td,
        th {
            text-align: left;
            padding: 5px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>

    <h2>Effecti - Teste DEV</h2>

    <table>
        <tr>
            <th  colspan="2">Informações dos Usuários Cadastrados</th>
        </tr>

        @foreach ($usuarios as $usuario)
        @php
            $endereco = explode(",",$usuario->endereco);
        @endphp
            <tr>
                <td><b>Id: </b> {{ $usuario->id }}  <br> <b>Nome: </b>{{ $usuario->nome }} <br> <b>Cpf: </b>{{ formatarCpf($usuario->cpf) }} <br><b>Data Nasc.: </b> {{ formatarDataPtBr($usuario->data_nascimento) }} <br>  <b>Status: </b>{{ $usuario->status }}</td>
                <td><b>Email: </b> {{ $usuario->email }} <br> <b>Telefone: </b> {{ formatarTelefone($usuario->telefone) }} <br> <b>Cep: </b> {{ formatarCep($usuario->cep) }} <br> <b>Estado: </b> {{ $usuario->estado }} <br> <b>Bairro: </b>{{ $usuario->bairro }} <br> <b>Rua: </b>{{ $endereco[0] }} ,<b>N°</b> {{ $endereco[1] }}</td>
            </tr>
        @endforeach
    </table>

</body>

</html>
