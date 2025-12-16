<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Exception;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Mail;
use App\Mail\UsuarioPdfMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ImportCsvRequest;

class ImportCsvUsuario extends Controller
{

    // Método para importar usuários de um arquivo CSV
    public function importCsv(ImportCsvRequest $request)
    {
        try {

            // Cabeçalhos esperados no CSV
            $headers = ['nome', 'email', 'password'];

            // Obeter o arquivo CSV envidado no pelo formulario
            $file = $request->file('file');

            // Esse trecho lê o CSV inteiro e coloca cada linha dentro de um array
            $rows = array_map(
                fn($line) => str_getcsv($line, ','),
                file($file->getRealPath())
            );

            // Remove o primeiro elemento de um array
            array_shift($rows);

            // Arrays auxiliares
            $arrayValues = []; // Armazena os dados para inserção em massa
            $duplicatedEmails = [];  // Armazena e-mails duplicados encontrados
            $numberRegisteredRecords = 0; // Contador de registros cadastrados

            // Ler cada linha do CSV
            foreach ($rows as $values) {

                // Verifica se a quantidade de valores da linha é igual à quantidade de colunas esperadas.
                if (count($values) !== count($headers)) {
                    continue;
                }

                // Combina valores com os cabeçalhos
                // Cria um array associativo, associando as colunas às suas respectivas linhas (valores).
                $ArrayUserData = array_combine($headers, $values);

                // Verificar e-mail duplicado
                $emailExists = Usuario::where('email', $ArrayUserData['email'])->exists();

                // Verifica se o email se o email já existe no banco
                if ($emailExists) {
                    $duplicatedEmails[] = $ArrayUserData['email'];
                    // Coloca no array email e continua o loop
                    continue;
                }

                // Montar array para inserção em massa
                $arrayValues[] = [
                    'nome'       => $ArrayUserData['nome'],
                    'email'      => $ArrayUserData['email'],
                    'password'   => Hash::make(Str::random(8)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Incrementar o contador de usuarios ja inserios no array
                $numberRegisteredRecords++;
            }

            // Se encontrou e-mails duplicados, não cadastra nada
            if (!empty($duplicatedEmails)) {
                return back()->withInput()->with('error', 'Importação cancelada! E-mails duplicados encontrados. E-mails: '
                    . implode(', <br>', $duplicatedEmails));
            }

            // Inserir os novos usuários no banco de dados
            // Use-se o insert para inserir múltiplos registros de uma vez, em massa. 
            Usuario::insert($arrayValues);

            return back()->with('success', 'Dados importados com sucesso. <br> Quantidade: ' . $numberRegisteredRecords);
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Dados não importados! Erro interno.');
        }
    }
}
