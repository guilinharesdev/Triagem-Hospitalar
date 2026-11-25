<?php

include_once '../src/paciente.php';
include_once '../src/busca.php';

$lerPaciente = file_get_contents(__DIR__ . '/../dados/paciente.json');
$pacientes = json_decode($lerPaciente, true);

$maiorId = 0;

foreach ($pacientes as $paciente) {
    if (isset($paciente['id'])) {
        $id = $paciente['id'];
        if ($id > $maiorId) {
            $maiorId = $id;
        }
    }
}

$novoId = $maiorId + 1;

$dadosPaciente = $_POST;
$dadosPaciente['id'] = $novoId;
$cadastrou = false;
if(!localizarPaciente($_POST['cpf']))
    $cadastrou = cadastrarPaciente($dadosPaciente);

if ($cadastrou) {
    $nome = $_POST['nome'];

    $filateste = [
        "nome" => $_POST['nome'],
        "gravidade" => $_POST['gravidade'],
        "id" => $novoId
    ];

    $enfileirar = cadastrarFila($filateste);
    if ($enfileirar) {
        header("Location: index.php?nome=" . $nome);
    }
} else {
    header("Location: index.php?tela=cadastro&aviso=" . 'CPF já utilizado! Tente usar um CPF válido.');
}