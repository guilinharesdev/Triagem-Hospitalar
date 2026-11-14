<?php

require_once __DIR__ . '/pilha.php';

define('CAMINHO_DO_ARQUIVO_FILA_JSON', __DIR__ . '/../dados/fila.json');

function carregarFila(): array {
    return file_exists(caminhoFila)
        ? (json_decode(file_get_contents(caminhoFila), true) ?? [])
        : [];
}

function salvarFila(array $fila): void {
    file_put_contents(caminhoFila, json_encode($fila, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function enfileirarPaciente(array $dados): array {
    $fila = carregarFila();

    $paciente = [
        'id'           => $dados['id'] ?? uniqid('pac_'),
        'nome'         => $dados['nome'] ?? 'Sem nome',
        'idade'        => $dados['idade'] ?? null,
        'sintomas'     => $dados['sintomas'] ?? '',
        'gravidade'    => (int) ($dados['gravidade'] ?? 1),
        'hora_chegada' => date('d/m/Y H:i:s'),
        'status'       => 'Aguardando'
    ];

    $fila[] = $paciente;
    salvarFila($fila);
    return $paciente;
}

// Função original do colega (mantida intacta)
function buscarProximoPaciente(array $fila): ?array {
    $proximoPaciente = null;
    $indiceAtual = null;

    foreach ($fila as $indice => $paciente) {
        if (!$proximoPaciente || $paciente['gravidade'] > $proximoPaciente['gravidade']) {
            $proximoPaciente = $paciente;
            $indiceAtual = $indice;
        }
    }

    return $proximoPaciente === null ? null : [$proximoPaciente, $indiceAtual];
}

// Chama o paciente escolhido pelo colega e envia para a sua pilha
function chamarPaciente($medicoId = null, string $obs = 'Atendimento realizado'): ?array {
    $fila = carregarFila();
    $proximo = buscarProximoPaciente($fila);

    if ($proximo === null) {
        return null;
    }

    $pacienteAntes = $proximo[0];
    array_splice($fila, $proximo[1], 1);
    salvarFila($fila);

    $pacienteDepois = array_merge($pacienteAntes, ['status' => 'Realocado para Leito', 'observacao' => $obs]);
    empilharAcao('ATENDIMENTO_REALIZADO', $pacienteAntes['id'] ?? $pacienteAntes['nome'], $pacienteAntes, $pacienteDepois, $medicoId);

    return $pacienteDepois;
}

function desfazerUltimoAtendimento(): ?array {
    $ultima = desempilharAcao();

    if ($ultima && ($ultima['acao'] ?? '') === 'ATENDIMENTO_REALIZADO' && !empty($ultima['dados_anteriores'])) {
        $fila = carregarFila();
        $fila[] = $ultima['dados_anteriores'];
        salvarFila($fila);
    }

    return $ultima;
}

function obterEstatisticasFila(): array {
    $fila = carregarFila();
    $niveis = array_count_values(array_column($fila, 'gravidade'));

    return [
        'total'      => count($fila),
        'emergencia' => $niveis[3] ?? 0,
        'urgencia'   => $niveis[2] ?? 0,
        'simples'    => $niveis[1] ?? 0
    ];
}
