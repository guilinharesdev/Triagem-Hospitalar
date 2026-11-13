<?php

include_once '../src/busca.php';
$buscou = localizarPaciente ($_GET['cpf']);
if ($buscou){
    $cpf = $_GET['cpf'];
    header("Location: index.php?cpf=".$cpf);    
}

?>