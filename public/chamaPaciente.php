<?php

session_start();

require_once __DIR__ . '/../src/fila.php';
require_once __DIR__ . '/../src/leitos.php';
require_once __DIR__ . '/../src/pilha.php';

function voltar(string $tipo, string $texto): void
{
    $_SESSION['vitacare_feedback'] = ['tipo' => $tipo, 'texto' => $texto];
    header('Location: index.php?tela=fila');
    exit;
}

$proximo = chamarPaciente();

$paciente = $proximo[0];  

$nome = $paciente['nome'];
$gravidade = (int) $paciente['gravidade'];
$idPaciente = (int) $paciente['id'];

$setor = $gravidade - 1;

$mapa = carregarLeitos();
$leito = ocuparLeito($mapa, $setor, $idPaciente);

if ($leito === null) {
    voltar('aviso', "Setor {$setor} está lotado. {$nome} permanece na fila.");
}

salvarLeitos($mapa);

//Remove da fila
excluirPacienteFila();

if (function_exists('verPaciente')) {
    verPaciente();
}

voltar('sucesso', "{$nome} alocado no setor {$setor}, leito {$leito}.");

?>