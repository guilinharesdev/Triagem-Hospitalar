<?php
$testePaciente = [
    'nome'      => 'Gui',
    'cpf'       => '123',
    'telefone'  => '123',
    'gravidade' => 1
];
//var_dump($testePaciente);
$teste = cadastrarPaciente($testePaciente);
//var_dump($teste);
/**
 * Essa funcao ira servir para cadastrar o paciente:
 * Essa funcao ira cadastrar os dados do paciente e salvar em um arquivo json
 */
function cadastrarPaciente(array $paciente){

    $caminho = '../dados/paciente.json';

    $lista = file_exists($caminho) ? json_decode(file_get_contents($caminho), true) : [];

    $lista[] = $paciente;

    $jsonPaciente = json_encode($lista, JSON_PRETTY_PRINT);

    $resultado = file_put_contents($caminho, $jsonPaciente);

    //Pegar o conteudo $paciente e tentar salvar em um arquivo
    if ($resultado === false) {
        return false;
    }

    else {
        return true;
    }

}


/**
 * Essa funcao ira servir para colocar o paciente na fila de espera
 */
function enfileirarPaciente(){


}


/**
 * Essa funcao ira servir para chamar o paciente para o leito
 */
function chamarPaciente(){


}
?>