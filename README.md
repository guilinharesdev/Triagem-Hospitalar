# 🏥 Sistema de Atendimento e Triagem Hospitalar

> Projeto Prático de **Lógica de Programação** — Proposta 1
> Desenvolvido em **PHP** (modo terminal / CLI), sem banco de dados externo.

---

## 📋 Sobre o projeto

Solução computacional para gerenciar o fluxo de **triagem**, a **fila de atendimento**, a **alocação de leitos** e o **histórico de prontuários** de um centro médico.

O fluxo do sistema é:

1. O paciente é **cadastrado** (nome, CPF, telefone e gravidade).
2. Ele entra na **fila de espera (FIFO)** para triagem e consulta.
3. Ao ser chamado, é **redirecionado para o setor de leitos** correspondente ao seu nível de gravidade.
4. Todas as ações ficam registradas no **histórico (pilha)** e todos os dados dos pacientes são gravados em um **banco de dados local** para análises futuras.

O foco do trabalho é a aplicação prática de **estruturas de dados lineares** e **persistência local em arquivos**, sem uso de bancos de dados externos (MySQL, PostgreSQL etc.).

## 👥 Equipe

| Nome  | Responsabilidade |
|-------|------------|------------------|
| Antonio Bernardo   |  _Ex.: Cadastro e banco local_ |
| Guilherme Linhares |  _Ex.: Fila e leitos_ |
| João Pedro Barreto |  _Ex.: Pilha, busca e ordenação_ |
| Lucas Rafael       |  _Ex.: Pilha, busca e ordenação_ |

**Disciplina:** Lógica de Programação
**Professor(a):** Leonardo Lucena
**Prazo:** 40 dias

---

## ✨ Funcionalidades

### 1. Cadastro de pacientes
Cada paciente é cadastrado com:

| Campo | Descrição | Validação |
|-------|-----------|-----------|
| **Nome** | Nome completo | Obrigatório |
| **CPF** | Documento do paciente | 11 dígitos numéricos, sem duplicidade na fila |
| **Telefone** | Contato com DDD | 10 ou 11 dígitos numéricos |
| **Gravidade** | Nível do problema (1 a 3) | Apenas 1, 2 ou 3 |

### 2. Níveis de gravidade

| Nível | Classificação | Setor de leitos de destino |
|-------|---------------|----------------------------|
| 🟢 **1** | **Pouco urgente** | Setor 0 — Atendimento comum |
| 🟡 **2** | **Urgente** | Setor 1 — Observação / Clínica |
| 🔴 **3** | **Emergência** | Setor 2 — Emergência / UTI |

### 3. Fila de espera (FIFO)
- Gerencia a espera para **triagem e consulta**, respeitando a ordem de chegada.
- Pacientes de **emergência (nível 3)** são inseridos com **regra de precedência**, passando à frente dos demais; entre pacientes do mesmo nível vale a ordem de chegada.
- Ao chamar o próximo paciente, o sistema o **redireciona automaticamente ao primeiro leito livre** do setor correspondente à sua gravidade.
- Se o setor estiver lotado, o paciente permanece na fila e o sistema exibe um aviso.

### 4. Histórico e desfazer (Pilha)
- Registra as ações do plantão (cadastro, chamada, ocupação e liberação de leito).
- Permite **desfazer (Undo)** a última ação e consultar o **último prontuário modificado**.

### 5. Mapa de leitos (Matriz 2D)
- Linhas = setores, colunas = leitos.
- `0` = livre, `1` = ocupado.
- Permite visualizar a ocupação, ocupar e liberar leitos.

### 6. Estatísticas e médicos (Vetor 1D)
- Estatísticas do dia: cadastrados, atendidos, por nível de gravidade, leitos ocupados.
- Lista consolidada de médicos e especialidades disponíveis.

### 7. Busca e ordenação
- **Busca por CPF** (linear ou binária).
- **Ordenação** (Bubble, Selection ou QuickSort, implementada manualmente) da lista final por **nome** ou **gravidade**.

### 8. Banco de dados local (persistência)
- Os dados são salvos em arquivos, sem servidor de banco de dados.
- O estado da fila, do histórico e dos leitos é restaurado ao reiniciar o programa.
- Todos os pacientes cadastrados ficam **armazenados permanentemente** para **análise futura**.

---

## 🧱 Estruturas de dados aplicadas

| Estrutura | Mapeamento no sistema hospitalar |
|-----------|----------------------------------|
| **Fila (FIFO)** | Gerenciamento da fila de espera para triagem e consulta. Pacientes prioritários (emergência) são inseridos com regras de precedência. |
| **Pilha (LIFO)** | Histórico de ações e atendimentos do plantão, permitindo desfazer (Undo) ou consultar o último prontuário modificado. |
| **Matriz (2D)** | Mapa de leitos (linhas = andares/setores, colunas = leitos). Controla ocupação: `0` = livre, `1` = ocupado. |
| **Vetor (1D)** | Estatísticas temporárias do dia e listagem consolidada de médicos/especialidades disponíveis. |
| **Busca e Ordenação** | Busca linear/binária por CPF. Ordenação (Bubble, Selection ou QuickSort) por nome ou gravidade. |
| **Persistência** | Manipulação de arquivos (txt, csv ou json) para salvar e carregar o estado das filas e do histórico ao reiniciar o programa. |

---

## 🗄️ Banco de dados local

O "banco de dados" é composto por arquivos na pasta `dados/`, em dois grupos:

**Estado do plantão** (restaurado ao reiniciar):

| Arquivo | Conteúdo |
|---------|----------|
| `fila.json` | Pacientes aguardando atendimento |
| `historico.json` | Pilha de ações do plantão |
| `leitos.json` | Matriz de ocupação dos leitos |
| `medicos.json` | Médicos e especialidades |

**Base permanente de pacientes** (para análise futura):

| Arquivo | Conteúdo |
|---------|----------|
| `pacientes.csv` | Registro de todos os pacientes cadastrados e seus atendimentos |

Exemplo de `pacientes.csv`:

```csv
id,nome,cpf,telefone,gravidade,data_cadastro,data_atendimento,setor,leito,status
1,Maria Souza,12345678900,71999990000,3,2026-10-29 19:30:00,2026-10-29 19:32:10,2,2,atendido
2,João Lima,98765432100,71988880000,1,2026-10-29 19:35:00,,,,aguardando
```

> O formato CSV permite abrir a base diretamente no Excel ou Google Planilhas para gerar relatórios e gráficos.

---

## 🛠️ Requisitos

- **PHP 8.0** ou superior
- Terminal (Windows PowerShell/CMD, Linux ou macOS)
- Nenhuma biblioteca ou banco de dados externo

```bash
php -v
```

---

## 🚀 Como executar

```bash
# 1. Clone o repositório
git clone <url-do-repositorio>
cd sistema-triagem-hospitalar

# 2. Execute o programa
php index.php
```

> Na primeira execução, a pasta e os arquivos de `dados/` são criados automaticamente.

---

## 📁 Estrutura de pastas

```
sistema-triagem-hospitalar/
├── index.php              # Ponto de entrada e menu principal
├── src/
│   ├── paciente.php       # Cadastro e validação de pacientes
│   ├── fila.php           # Fila (FIFO) com precedência
│   ├── pilha.php          # Pilha (LIFO) de histórico / undo
│   ├── leitos.php         # Matriz de leitos e redirecionamento
│   ├── medicos.php        # Vetor de médicos e especialidades
│   ├── busca.php          # Busca linear / binária por CPF
│   ├── ordenacao.php      # Algoritmos de ordenação
│   ├── arquivo.php        # Leitura e gravação (banco local)
│   └── relatorios.php     # Estatísticas e relatórios
├── dados/
│   ├── fila.json
│   ├── historico.json
│   ├── leitos.json
│   ├── medicos.json
│   └── pacientes.csv
├── README.md
└── DOCUMENTACAO.md
```

---

## 🖥️ Menu principal (exemplo)

```
==========================================
   SISTEMA DE TRIAGEM HOSPITALAR
==========================================
 1 - Cadastrar paciente
 2 - Exibir fila de espera
 3 - Chamar próximo paciente (redireciona ao leito)
 4 - Mapa de leitos
 5 - Liberar leito
 6 - Buscar paciente por CPF
 7 - Relatório ordenado (nome / gravidade)
 8 - Histórico / desfazer última ação
 9 - Médicos e especialidades
10 - Estatísticas do dia
 0 - Salvar e sair
==========================================
Escolha uma opção:
```

---

## 🔄 Fluxo de atendimento

```
Cadastro (nome, CPF, telefone, gravidade 1-3)
        │
        ▼
Grava no banco local (pacientes.csv)
        │
        ▼
Entra na fila FIFO ── nível 3 passa à frente (precedência)
        │
        ▼
Chamada do próximo paciente
        │
        ▼
Gravidade 1 ─► Setor 0 (Atendimento comum)
Gravidade 2 ─► Setor 1 (Observação/Clínica)
Gravidade 3 ─► Setor 2 (Emergência/UTI)
        │
        ▼
Leito marcado como ocupado (1) + ação empilhada no histórico
```

---

## ✅ Checklist de entrega

- [ ] Cadastro de pacientes (nome, CPF, telefone, gravidade)
- [ ] Fila FIFO com precedência de emergência
- [ ] Redirecionamento ao leito conforme a gravidade
- [ ] Pilha (LIFO) com desfazer
- [ ] Matriz 2D de leitos
- [ ] Vetores (estatísticas e médicos)
- [ ] Busca por CPF
- [ ] Ordenação por nome e gravidade
- [ ] Persistência do estado ao reiniciar
- [ ] Banco de dados local para análise futura
- [ ] README e documentação

---

## 📄 Licença

Projeto acadêmico, desenvolvido para fins educacionais.
