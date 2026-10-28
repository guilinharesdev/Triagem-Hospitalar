# Documentação Técnica — Sistema de Atendimento e Triagem Hospitalar

**Disciplina:** Lógica de Programação • **Proposta 1** • **Linguagem:** PHP (CLI) • **Prazo:** 40 dias

---

## 1. Descrição geral

O objetivo do projeto é desenvolver uma solução computacional para gerenciar o fluxo de triagem, as filas de atendimento emergencial, a alocação de leitos e o histórico de prontuários em um centro médico.

Os alunos devem aplicar conceitos avançados de **estruturas de dados lineares** e **persistência de dados local**, sem suporte a bancos de dados externos.

---

## 2. Aplicação exigida das estruturas de dados

| Estrutura | Mapeamento no sistema hospitalar |
|-----------|----------------------------------|
| **Fila (FIFO)** | Gerenciamento da fila de espera para triagem e consulta. Pacientes prioritários (emergência) são inseridos com regras de precedência. |
| **Pilha (LIFO)** | Histórico de ações e atendimentos realizados no plantão, permitindo operação de desfazer (Undo) ou consulta do último prontuário modificado. |
| **Matriz (2D)** | Mapa de leitos (linhas = andares/setores, colunas = leitos). Controla ocupação: `0` = livre, `1` = ocupado. |
| **Vetor (1D)** | Estatísticas temporárias do dia e listagem consolidada de médicos/especialidades disponíveis. |
| **Busca e Ordenação** | Busca linear/binária por CPF. Ordenação (Bubble, Selection ou QuickSort) da lista final por nome ou gravidade. |
| **Persistência** | Manipulação de arquivos (txt, csv ou json) para salvar e carregar o estado das filas e do histórico ao reiniciar o programa. |

---

## 3. Arquitetura de interface

| Opção | Descrição | Escolha |
|-------|-----------|---------|
| **A — Terminal / CLI** | Menu interativo em texto, com navegação por opções numéricas para cadastro, chamadas e relatórios. | ✅ Adotada |
| **B — Web simplificado (PHP)** | HTML5 e CSS3 puros, sem JavaScript. Formulários recarregam a página mantendo o estado no arquivo local. | — |

---

## 4. Modelagem dos dados

### 4.1 Paciente

```php
$paciente = [
    'id'          => 1,
    'nome'        => 'Maria Souza',
    'cpf'         => '12345678900',
    'idade'       => 45,
    'gravidade'   => 2,            // 1 = emergência ... 4 = não urgente
    'sintomas'    => 'Dor torácica',
    'chegada'     => '2026-10-28 17:30:00',
    'status'      => 'aguardando', // aguardando | em_atendimento | atendido
];
```

### 4.2 Ação do histórico (pilha)

```php
$acao = [
    'tipo'      => 'CADASTRO',     // CADASTRO | CHAMADA | OCUPAR_LEITO | LIBERAR_LEITO
    'paciente'  => $paciente,
    'detalhes'  => ['setor' => 0, 'leito' => 3],
    'data_hora' => '2026-10-28 17:31:00',
];
```

### 4.3 Mapa de leitos (matriz)

```php
// 3 setores x 5 leitos
$leitos = [
    [0, 1, 0, 0, 1],  // Setor 0 — Emergência
    [0, 0, 0, 1, 0],  // Setor 1 — Clínica geral
    [1, 0, 0, 0, 0],  // Setor 2 — UTI
];
```

### 4.4 Vetores

```php
$medicos = [
    ['nome' => 'Dr. Carlos', 'especialidade' => 'Clínico Geral'],
    ['nome' => 'Dra. Ana',   'especialidade' => 'Cardiologia'],
];

$estatisticas = [
    'cadastrados' => 0,
    'atendidos'   => 0,
    'emergencias' => 0,
    'leitos_ocupados' => 0,
];
```

---

## 5. Módulos e algoritmos

### 5.1 Fila com prioridade (`fila.php`)

| Função | Descrição |
|--------|-----------|
| `enfileirar($fila, $paciente)` | Insere o paciente. Emergências (nível 1) entram à frente dos demais, mantendo a ordem de chegada entre emergências. |
| `desenfileirar($fila)` | Remove e retorna o primeiro da fila. |
| `exibirFila($fila)` | Lista os pacientes aguardando. |
| `filaVazia($fila)` | Retorna `true` se não houver pacientes. |

### 5.2 Pilha de histórico (`pilha.php`)

| Função | Descrição |
|--------|-----------|
| `empilhar($pilha, $acao)` | Registra uma ação no topo. |
| `desempilhar($pilha)` | Remove e retorna a última ação (base do **Undo**). |
| `topo($pilha)` | Consulta o último prontuário/ação sem remover. |
| `desfazer($fila, $pilha, $leitos)` | Reverte a última ação conforme seu tipo. |

**Regras do desfazer:**

| Ação desfeita | Efeito |
|---------------|--------|
| `CADASTRO` | Remove o paciente da fila |
| `CHAMADA` | Devolve o paciente ao início da fila |
| `OCUPAR_LEITO` | Marca o leito como livre (`0`) |
| `LIBERAR_LEITO` | Marca o leito como ocupado (`1`) |

### 5.3 Mapa de leitos (`leitos.php`)

| Função | Descrição |
|--------|-----------|
| `exibirMapa($leitos)` | Imprime a matriz com legenda (livre/ocupado). |
| `ocuparLeito($leitos, $setor, $leito)` | Valida e define `1`. |
| `liberarLeito($leitos, $setor, $leito)` | Valida e define `0`. |
| `primeiroLeitoLivre($leitos)` | Percorre a matriz e retorna a primeira posição livre. |

### 5.4 Busca (`busca.php`)

| Função | Descrição |
|--------|-----------|
| `buscaLinear($lista, $cpf)` | Percorre a lista sequencialmente. |
| `buscaBinaria($lista, $cpf)` | Exige lista previamente ordenada por CPF. |

### 5.5 Ordenação (`ordenacao.php`)

Algoritmo escolhido: **_Bubble / Selection / QuickSort_** (definir).

| Função | Critério |
|--------|----------|
| `ordenarPorNome($lista)` | Ordem alfabética |
| `ordenarPorGravidade($lista)` | Do mais grave ao menos grave |

> Os algoritmos devem ser **implementados manualmente**, sem `sort()`, `usort()` e similares.

### 5.6 Persistência (`arquivo.php`)

| Função | Descrição |
|--------|-----------|
| `salvarDados($caminho, $dados)` | Grava o estado em JSON. |
| `carregarDados($caminho)` | Lê o arquivo; retorna estrutura vazia se não existir. |

---

## 6. Fluxo do sistema

```
Início
  │
  ├─► Carrega dados (fila, histórico, leitos, médicos)
  │
  ├─► Exibe menu ◄─────────────────┐
  │       │                         │
  │       ▼                         │
  │   Executa opção ────────────────┘
  │       │
  │      (0 - Sair)
  ▼
Salva dados em arquivo
  │
Fim
```

---

## 7. Menu de opções

| Opção | Ação |
|-------|------|
| 1 | Cadastrar paciente na fila |
| 2 | Chamar próximo paciente |
| 3 | Exibir fila de espera |
| 4 | Mapa de leitos |
| 5 | Ocupar / liberar leito |
| 6 | Buscar paciente por CPF |
| 7 | Relatório ordenado (nome / gravidade) |
| 8 | Histórico e desfazer última ação |
| 9 | Médicos e especialidades |
| 10 | Estatísticas do dia |
| 0 | Salvar e sair |

---

## 8. Validações

- CPF com 11 dígitos numéricos e sem duplicidade na fila
- Nome obrigatório (não vazio)
- Gravidade entre 1 e 4
- Setor e leito dentro dos limites da matriz
- Não ocupar leito já ocupado, nem liberar leito já livre
- Não chamar paciente com a fila vazia
- Não desfazer com a pilha vazia

---

## 9. Casos de teste sugeridos

| # | Cenário | Resultado esperado |
|---|---------|--------------------|
| 1 | Cadastrar 3 pacientes de gravidade 3 | Atendidos na ordem de chegada |
| 2 | Cadastrar paciente de gravidade 1 após os demais | Vai para a frente da fila |
| 3 | Chamar paciente com fila vazia | Mensagem de aviso, sem erro |
| 4 | Ocupar leito já ocupado | Operação recusada |
| 5 | Desfazer após cadastro | Paciente removido da fila |
| 6 | Buscar CPF inexistente | Mensagem "não encontrado" |
| 7 | Fechar e reabrir o programa | Fila, histórico e leitos preservados |
| 8 | Ordenar por gravidade | Lista do nível 1 ao 4 |

---

## 10. Cronograma sugerido (40 dias)

| Período | Entrega |
|---------|---------|
| Dias 1–5 | Planejamento, modelagem e estrutura de pastas |
| Dias 6–12 | Fila com prioridade e cadastro de pacientes |
| Dias 13–18 | Pilha de histórico e desfazer |
| Dias 19–24 | Matriz de leitos e vetores (médicos/estatísticas) |
| Dias 25–30 | Busca e ordenação |
| Dias 31–35 | Persistência em arquivos |
| Dias 36–38 | Testes e correções |
| Dias 39–40 | Documentação final e apresentação |

---

## 11. Critérios de avaliação (barema)

> Preencher com os pesos do barema fornecido pelo professor.

| Critério | Pontos |
|----------|--------|
| Fila (FIFO) com prioridade | _ |
| Pilha (LIFO) e desfazer | _ |
| Matriz de leitos | _ |
| Vetores | _ |
| Busca e ordenação | _ |
| Persistência em arquivo | _ |
| Interface e usabilidade | _ |
| Organização do código e documentação | _ |
| **Total** | **_** |
