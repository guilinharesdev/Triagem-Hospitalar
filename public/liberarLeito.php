<?php
session_start();
require_once __DIR__ . '/../src/leitos.php';

$setor = (int) ($_POST['setor'] ?? -1);
$indice = (int) ($_POST['leito'] ?? -1);

$mapa = carregarLeitos();

// lê quem estava ANTES de liberar (o liberar zera esse campo)
$idPaciente = pacienteNoLeito($mapa, $setor, $indice);

if (liberarLeito($mapa, $setor, $indice) && salvarLeitos($mapa)) {
    $texto = "Leito L{$indice} do setor {$setor} liberado.";
    if ($idPaciente !== null) {
        $texto .= " Paciente #{$idPaciente} saiu do leito.";
    }
    $_SESSION['vitacare_feedback'] = ['tipo' => 'sucesso', 'texto' => $texto];
} else {
    $_SESSION['vitacare_feedback'] = [
        'tipo'  => 'aviso',
        'texto' => 'O leito já está livre.',
    ];
}

header('Location: index.php?tela=leitos');
exit;

?>
