<?php

function mapaLeitos(): array
{
    $mapa = [];
    $idLeito = 0;

    for ($setor = 0; $setor < 3; $setor++) {
        $linha = [];

        for ($indice = 0; $indice < 5; $indice++) {
            $linha[] = [
                'id'          => $idLeito,
                'ocupado'     => false,
                'paciente_id' => null,
            ];

            $idLeito++;
        }

        $mapa[] = $linha;
    }

    return $mapa;
}

function leitoOcupado(array $leito): bool
{
    return ($leito['ocupado'] ?? false) === true;
}

function contarOcupados(array $mapa, int $setor): int
{
    $total = 0;

    foreach ($mapa[$setor] ?? [] as $leito) {
        if (leitoOcupado($leito)) {
            $total++;
        }
    }

    return $total;
}

function setorLotado(array $mapa, int $setor): bool
{
    $leitos = $mapa[$setor] ?? [];

    return $leitos !== [] && contarOcupados($mapa, $setor) === count($leitos);
}

function primeiroLeitoLivre(array $mapa, int $setor): ?int
{
    foreach ($mapa[$setor] ?? [] as $indice => $leito) {
        if (!leitoOcupado($leito)) {
            return $indice;
        }
    }

    return null;
}

function ocuparLeito(array &$mapa, int $setor, int $pacienteId): ?int
{
    if ($pacienteId <= 0) {
        return null;
    }

    if (setorLotado($mapa, $setor)) {
        return null;
    }

    $indice = primeiroLeitoLivre($mapa, $setor);

    if ($indice === null) {
        return null;
    }

    $mapa[$setor][$indice]['ocupado'] = true;
    $mapa[$setor][$indice]['paciente_id'] = $pacienteId;

    return $indice;
}

function liberarLeito(array &$mapa, int $setor, int $indice): bool
{
    if (!isset($mapa[$setor][$indice])) {
        return false;
    }

    if (!leitoOcupado($mapa[$setor][$indice])) {
        return false;
    }

    $mapa[$setor][$indice]['ocupado'] = false;
    $mapa[$setor][$indice]['paciente_id'] = null;

    return true;
}

function idDoLeito(array $mapa, int $setor, int $indice): ?int
{
    if (!isset($mapa[$setor][$indice]['id'])) {
        return null;
    }

    return (int) $mapa[$setor][$indice]['id'];
}

function pacienteNoLeito(array $mapa, int $setor, int $indice): ?int
{
    if (!isset($mapa[$setor][$indice])) {
        return null;
    }

    $id = $mapa[$setor][$indice]['paciente_id'];

    return $id === null ? null : (int) $id;
}

function caminhoLeitos(): string
{
    return __DIR__ . '/../dados/leitos.json';
}

function validarMapaLeitos($dados): bool
{
    if (!is_array($dados) || count($dados) !== 3) {
        return false;
    }

    foreach ($dados as $linha) {
        if (!is_array($linha) || count($linha) !== 5) {
            return false;
        }

        foreach ($linha as $leito) {
            if (!is_array($leito)) {
                return false;
            }

            if (!isset($leito['id']) || !is_int($leito['id'])) {
                return false;
            }

            if (!isset($leito['ocupado']) || !is_bool($leito['ocupado'])) {
                return false;
            }

            if (!array_key_exists('paciente_id', $leito)) {
                return false;
            }

            $temPaciente = $leito['paciente_id'] !== null;

            if ($leito['ocupado'] !== $temPaciente) {
                return false;
            }
        }
    }

    return true;
}

function carregarLeitos(): array
{
    $caminho = caminhoLeitos();

    if (!is_readable($caminho)) {
        return mapaLeitos();
    }

    $dados = json_decode((string) file_get_contents($caminho), true);

    return validarMapaLeitos($dados) ? $dados : mapaLeitos();
}

function salvarLeitos(array $leitos): bool
{
    if (!validarMapaLeitos($leitos)) {
        return false;
    }

    $caminho = caminhoLeitos();
    $pasta   = dirname($caminho);

    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $json = json_encode($leitos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    return file_put_contents($caminho, $json, LOCK_EX) !== false;
}

?>