<?php

include_once '../src/paciente.php';
$cadastrou = cadastrarPaciente ($_POST);
if ($cadastrou){
    $nome = $_POST['nome'];
    $enfileirar = cadastrarFila ($_POST);
    if ($enfileirar) {
        header("Location: index.php?nome=".$nome); 
    }
    else {
        
    } 
}

?>