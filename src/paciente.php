<?php

/**
 * Essa funcao ira servir para cadastrar o paciente:
 * Essa funcao ira cadastrar os dados do paciente e salvar em um arquivo json
 */
function cadastrarPaciente(array $paciente): bool{

    $caminho = '../dados/paciente.json';

    $lista = file_exists($caminho) ? json_decode(file_get_contents($caminho), true) : [];

    $lista[] = $paciente;

    $jsonPaciente = json_encode($lista, JSON_PRETTY_PRINT);

    $resultado = file_put_contents($caminho, $jsonPaciente);

    //Pegar o conteudo $paciente e tentar salvar em um arquivo
    if ($resultado === false) {
        return false;
    }
    
    return true;    

}

function cadastrarFila(array $fila): bool{

    $caminho = '../dados/fila.json';

    $lista = file_exists($caminho) ? json_decode(file_get_contents($caminho), true) : [];

    $lista[] = $fila;

    $jsonFila = json_encode($lista, JSON_PRETTY_PRINT);

    $resultado = file_put_contents($caminho, $jsonFila);

    //Pegar o conteudo $paciente e tentar salvar em um arquivo
    if ($resultado === false) {
        return false;
    }
    
    return true;    

}

?>