<?php

function contarOcupados(array $mapa, int $setor): int {

    $leitos = $mapa[$setor] ?? [];
    $total = 0;

    foreach ($leitos as $leito) {
        if ($leito === true) {
            $total++;
        }
    }

    return $total;
    
}

function setorLotado(array $mapa, int $setor): bool {

    $leitos = $mapa[$setor] ?? [];

    return $leitos !== [] && contarOcupados($mapa, $setor) === count($leitos);

}

function primeiroLeitoLivre(array $mapa, int $setor): ?int {

    $leitos = $mapa[$setor] ?? [];

    foreach ($leitos as $indice => $leito) {
        if ($leito === false) {
            return $indice;
        }
    }

    return null;

}

function ocuparLeito (array &$mapa, int $setor): ?int {

    if (setorLotado($mapa, $setor)) {
        return null;
    }

    $leito = primeiroLeitoLivre($mapa, $setor);

    if ($leito === null) {
        return null;
    }

    $mapa[$setor][$leito] = true;

    return $leito;

}

function liberarLeito (array &$mapa, int $setor, int $leito): bool {

    if (!isset($mapa[$setor][$leito])) {
        return false;
    }

    if ($mapa[$setor][$leito]!==true) {
        return false;
    }

    $mapa[$setor][$leito] = false;

    return true;
}

function salvarLeitos(array $leitos): bool {

    $caminho = '../dados/leitos.json';

    $lista = file_exists($caminho) ? json_decode(file_get_contents($caminho), true) : [];

    $lista[] = $leitos;

    $jsonLeitos = json_encode($lista, JSON_PRETTY_PRINT);

    $resultado = file_put_contents($caminho, $jsonLeitos);

    //Pegar o conteudo $leitos e tentar salvar em um arquivo
    if ($resultado === false) {
        return false;
    }
}


?>