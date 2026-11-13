<?php

//Ler pacientes na fila de espera

$lerFila = file_get_contents(__DIR__ . '/../dados/fila.json');
$fila = json_decode($lerFila, true);

foreach ($fila as $paciente) {
    $nome = $paciente["nome"];
    $gravidade = $paciente["gravidade"];

    echo "Nome: $nome\n";
    echo "Gravidade: $gravidade\n";
}

/**
 * Essa funcao ira servir para chamar o paciente para o leito
 */
function chamarPaciente(array $fila): ?array
{
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

$proximoPaciente = chamarPaciente($fila);

if ($proximoPaciente !== null) {

    var_dump($proximoPaciente[0]);
    echo "Posicao: " . $proximoPaciente[1] . "\n";

    $indicePaciente = $proximoPaciente[1];

    $pacienteRemovido = array_splice($fila, offset: $indicePaciente, length: 1);
    var_dump($fila);

    $filaAtualizada = json_encode($fila, JSON_PRETTY_PRINT);
    file_put_contents(__DIR__ . '/../dados/fila.json', $filaAtualizada);
}
