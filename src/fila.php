<?php

include_once '../dados/fila.json';
//Essa funcao ira servir para colocar o paciente na fila de espera

$fila = ['fila.json'];

var_dump($fila);
function enfileirarPaciente(array $fila):void{
    array_push ($fila);
}

enfileirarPaciente($fila);

/**
 * Essa funcao ira servir para chamar o paciente para o leito
 */
function chamarPaciente(){


}
?>