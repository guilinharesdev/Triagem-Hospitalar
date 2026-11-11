<?php

include_once '../src/paciente.php';
$cadastrou = cadastrarPaciente ($_POST);
if ($cadastrou){
    $nome = $_POST['nome'];
    header("Location: index.php?nome=".$nome);    
}

?>