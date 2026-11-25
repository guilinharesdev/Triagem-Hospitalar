<?php

function mapaLeitos () {
return [
    [0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0]
];
}

function contarOcupados(array $mapa, int $setor): int {

    $leitos = $mapa[$setor] ?? [];
    $total = 0;

    foreach ($leitos as $leito) {
        if ($leito === 1) {
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
        if ($leito === 0) {
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

    $mapa[$setor][$leito] = 1;

    return $leito;

}

function liberarLeito (array &$mapa, int $setor, int $leito): bool {

    if (!isset($mapa[$setor][$leito])) {
        return false;
    }

    if ($mapa[$setor][$leito]!==1) {
        return false;
    }

    $mapa[$setor][$leito] = 0;

    return true;
}

?>