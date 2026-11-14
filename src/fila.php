<?php

//Ler pacientes na fila de espera
define('CAMINHO_DO_ARQUIVO_FILA_JSON', __DIR__ . '/../dados/fila.json');

/**
 * Busca os dados da fila.json
 * @return array|bool
 */
function carregarFila(): array|bool
{
    if (file_exists(CAMINHO_DO_ARQUIVO_FILA_JSON)) {
        $lerFila = file_get_contents(CAMINHO_DO_ARQUIVO_FILA_JSON);
        $fila = json_decode($lerFila, true);

        return $fila;
    }
    return false;
}

/**
 * Essa funcao ira servir para chamar o paciente para o leito
 */
function chamarPaciente(): ?array
{

    $fila = carregarFila();

    if(!$fila) {
        return null;
    }

    $proximoPaciente = null;
    $indiceAtual = null;

    foreach ($fila as $indice => $paciente) {

        if (!$proximoPaciente) {
            $proximoPaciente = $paciente;
            $indiceAtual = $indice;
        }
        if ($proximoPaciente) {
            if ($paciente['gravidade'] > $proximoPaciente['gravidade']) {
                $proximoPaciente = $paciente;
                $indiceAtual = $indice;
            }
        }
    }
    if ($proximoPaciente === null) {
        return null;
    }
    return [$proximoPaciente, $indiceAtual];
}

/**
 * Essa função irá pegar o paciente que foi chamado, e excluir ele da fila de espera
 * @return void
 */
function excluirPacienteFila():bool {
    $fila = carregarFila();

    $proximoPaciente = chamarPaciente($fila);

    if ($proximoPaciente !== null) {

     var_dump($proximoPaciente[0]);
     $indicePaciente = $proximoPaciente[1];

     $pacienteRemovido = array_splice($fila, offset: $indicePaciente, length: 1);

     $filaAtualizada = json_encode($fila, JSON_PRETTY_PRINT);
     file_put_contents(__DIR__ . '/../dados/fila.json', $filaAtualizada);
     var_dump($fila);
}




