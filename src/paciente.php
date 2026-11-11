<?php
$listaPacientes = [];
$paciente = [
    "nome" => "",
    "cpf" => (int)'',
    "telefone" => (int)"",
    "gravidade" => (int) ""
];




/**
 * Essa funcao ira servir para cadastrar o paciente:
 * Essa funcao ira cadastrar os dados do paciente e salvar em um arquivo json
 */
function cadastrarPaciente(array $paciente){

    $nome = $paciente['nome'];
    $cpf = $paciente['cpf'];
    $telefone = $paciente['telefone'];
    $gravidade = $paciente['gravidade'];

    $resultado = file_put_contents('../dados/paciente.json', $paciente, FILE_APPEND);

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