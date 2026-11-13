<?php

//Essa funcao ira servir para colocar o paciente na fila de espera

$lerFila = file_get_contents('../dados/fila.json');
$fila = json_decode($lerFila, true);

foreach ($fila as $paciente) {
    $nome = $paciente["nome"];
    $gravidade = $paciente["gravidade"];

    echo "Nome: $nome\n";
    echo "Gravidade: $gravidade\n";
}


function enfileirarPaciente(array $fila, array $paciente): array
{
    array_push($fila, $paciente);
    return $fila;
}
$fila = enfileirarPaciente($fila, $paciente);
$filaJson = json_encode($fila);
$resultado = file_put_contents('fila.json', $lerFila);

var_dump($fila);

/**
 * Essa funcao ira servir para chamar o paciente para o leito
 */
function chamarPaciente() {}
