<?php

// Define o fuso horário padrão, registrando a data e hora que entram no histórico
date_default_timezone_set('America/Bahia');

define('caminhoPilha', __DIR__ . '/../dados/historico.json');

function carregarPilha(): array {
    if (!file_exists(caminhoPilha)) {
        return [];
    }
    return json_decode(file_get_contents(caminhoPilha), true) ?? [];
}

function salvarPilha(array $pilha): void {
    file_put_contents(
        caminhoPilha,
        json_encode($pilha, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
    );
}

function empilharAcao(string $acao, $pacienteId, array $dadosAnteriores, array $dadosNovos, $medicoId = null): void {
    $pilha = carregarPilha();

    $pilha[] = [
        'acao'             => $acao,
        'paciente_id'      => $pacienteId,
        'medico_id'        => $medicoId,
        'dados_anteriores' => $dadosAnteriores,
        'dados_novos'      => $dadosNovos,
        'timestamp'        => date('d/m/Y H:i:s')
    ];

    salvarPilha($pilha);
}

function consultarTopoPilha(): ?array {
    $pilha = carregarPilha();
    return empty($pilha) ? null : end($pilha);
}

function desempilharAcao(): ?array {
    $pilha = carregarPilha();
    if (empty($pilha)) {
        return null;
    }

    $ultimaAcao = array_pop($pilha);
    salvarPilha($pilha);

    return $ultimaAcao;
}

function listarHistoricoPlantao(): array {
    return array_reverse(carregarPilha());
}