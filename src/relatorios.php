<?php

include_once(__DIR__ . '/../src/pilha.php');

function contarPacientesAtendidos(){

$pilha = carregarPilha();

$contador = 0;

foreach ($pilha as $item) {
        if ($item['acao'] === 'Chamado para atendimento') {
            $contador++;
        }
    }

    return $contador;
}

function contarPorGrau($grau) {
    $pilha = carregarPilha();
    $contador = 0;

    foreach ($pilha as $item) {
        if ($item['acao'] === 'Chamado para atendimento') {
            if ($item['dados_novos']['gravidade'] == $grau) {
                $contador++;
            }
        }
    }

    return $contador;
}

//$totalAtendidos = contarPacientesAtendidos();
//$totalGrau3 = contarPorGrau(3);
//$totalGrau2 = contarPorGrau(2);
//$totalGrau1 = contarPorGrau(1);