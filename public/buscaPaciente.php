<?php

include_once '../src/busca.php';

$buscou = localizarPaciente ($_GET['cpf']);

if ($buscou){
   //var_dump($buscou);exit();
    
    header("Location: index.php?tela=busca&nome=".$buscou['nome'].'&cpf='.$buscou['cpf'].'&telefone='.$buscou['telefone']
            .'&id='.$buscou['id'].'&gravidade='.$buscou['gravidade']);    
} else {
    header("Location: index.php?tela=busca&nome="."Não encontrado".'&cpf='."Não encontrado".'&telefone='."Não encontrado"
            .'&id='."Não encontrado".'&gravidade='."Não encontrado");    
}

?>