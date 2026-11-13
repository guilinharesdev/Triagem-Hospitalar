<?php

session_start();

require_once __DIR__ . '/../src/pilha.php';
require_once __DIR__ . '/../src/fila.php';

function escapar($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

function parametro(array $fonte, string $nome, string $padrao = ''): string
{
    return is_string($fonte[$nome] ?? null) ? $fonte[$nome] : $padrao;
}

function processarAcao(string $acao, array $destinos, ?array &$avisos): void
{
    if ($acao === 'chamar') {
        $atendido = chamarPaciente();
        $avisos = $atendido
            ? ['tipo' => 'sucesso', 'texto' => 'Paciente chamado: ' . ($atendido['nome'] ?? 'Paciente') . '.']
            : ['tipo' => 'aviso', 'texto' => 'Nenhum paciente aguardando na fila.'];
        return;
    }

    if ($acao === 'desfazer') {
        $avisos = desfazerUltimoAtendimento()
            ? ['tipo' => 'sucesso', 'texto' => 'Última ação desfeita e paciente devolvido à fila.']
            : ['tipo' => 'aviso', 'texto' => 'Nenhuma ação no histórico para desfazer.'];
        return;
    }

    if (isset($destinos[$acao])) {
        $avisos = ['tipo' => 'aviso', 'texto' => 'Esta operação ainda não está disponível. Nenhum dado foi alterado.'];
    }
}

$telas = [
    'inicio'     => 'Painel inicial',
    'cadastro'   => 'Cadastrar paciente',
    'fila'       => 'Fila de espera',
    'leitos'     => 'Mapa de leitos',
    'busca'      => 'Buscar paciente',
    'historico'  => 'Histórico de ações',
    'medicos'    => 'Médicos e especialidades',
    'relatorios' => 'Relatórios e estatísticas'
];

$destinos = ['chamar' => 'fila', 'liberar' => 'leitos', 'buscar' => 'busca', 'desfazer' => 'historico', 'relatorio' => 'relatorios'];

$acao = parametro($_POST, 'acao', parametro($_GET, 'acao'));
$nomeCadastrado = trim(parametro($_GET, 'nome'));

$tela = parametro($_GET, 'tela', $nomeCadastrado !== '' ? 'cadastro' : ($destinos[$acao] ?? 'inicio'));
$tela = isset($telas[$tela]) ? $tela : 'inicio';

$avisos = $_SESSION['vitacare_feedback'] ?? null;
unset($_SESSION['vitacare_feedback']);
processarAcao($acao, $destinos, $avisos);

$abas = ['dia' => 'Estatísticas do dia', 'distribuicao' => 'Por gravidade', 'ordenado' => 'Relatório ordenado'];
$aba = parametro($_GET, 'aba', $acao === 'relatorio' ? 'ordenado' : 'dia');
$aba = isset($abas[$aba]) ? $aba : 'dia';

$ordem = in_array(parametro($_GET, 'ordem', 'nome'), ['nome', 'gravidade'], true) ? parametro($_GET, 'ordem', 'nome') : 'nome';

?>


<!doctype html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="theme-color" content="#08776b">

    <title><?= escapar($telas[$tela]) ?> · VitaCare</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <a class="pular" href="#conteudo">Pular para o conteúdo</a>

    <input type="checkbox" id="menu-toggle" class="menu-toggle" aria-label="Abrir ou fechar menu"

        aria-controls="navegacao">

    <label for="menu-toggle" class="menu-botao">☰ Menu</label>

    <aside class="sidebar" id="navegacao">

        <a class="logo" href="index.php"><span class="logo-icone"

                aria-hidden="true">+</span><span><strong>VitaCare</strong><small>Triagem Hospitalar</small></span></a>

        <nav aria-label="Menu principal">

            <?php foreach ($telas as $chave => $rotulo): ?>

                <?php if ($chave === 'inicio' || $chave === 'busca'): ?>

                    <p class="nav-titulo"><?= $chave === 'inicio' ? 'Principal' : 'Gerenciamento' ?></p><?php endif; ?>

                <a href="index.php?tela=<?= $chave ?>" <?= $tela === $chave ? ' class="ativo" aria-current="page"' : '' ?>><?= escapar($rotulo) ?></a>

            <?php endforeach; ?>

        </nav>

        <p class="sidebar-nota">Organização e cuidado<br>em cada atendimento.</p>

    </aside>

    <div class="pagina">

        <header class="topbar"><span>Recepção / <?= escapar($telas[$tela]) ?></span><span class="selo">Projeto

                acadêmico</span></header>

        <main id="conteudo" tabindex="-1">

            <header class="pagina-titulo">

                <p class="sobretitulo">VITACARE · ATENDIMENTO</p>

                <h1><?= $tela === 'inicio' ? 'Painel de atendimento' : escapar($telas[$tela]) ?></h1>

                <p><?= $tela === 'inicio' ? 'Bem-vindo. Organize os próximos passos do atendimento.' : 'Tudo o que você precisa para esta etapa do atendimento.' ?>

                </p>

            </header>

            <?php if ($avisos): ?>

                <p class="mensagem <?= escapar($avisos['tipo']) ?>" role="status"><?= escapar($avisos['texto']) ?></p>

            <?php endif; ?>

            <section data-tela="<?= $tela ?>" aria-label="<?= escapar($telas[$tela]) ?>">

                <?php switch ($tela):

                    case 'inicio': ?>

                        <!-- Painel: somente resumo e atalhos. -->

                        <div class="indicadores">

                            <?php foreach (['Pacientes na fila', 'Atendimentos realizados', 'Leitos ocupados'] as $indicador): ?>

                                <article class="card indicador">

                                    <h2><?= $indicador ?></h2><strong aria-label="Indisponível">—</strong><small>Informação

                                        indisponível</small>

                                </article>

                            <?php endforeach; ?>

                        </div>

                        <div class="acoes"><a class="btn btn-primario" href="index.php?tela=cadastro">+ Cadastrar paciente</a><a

                                class="btn" href="index.php?tela=fila">Ver fila de espera →</a></div>

                        <article class="card proximo">

                            <h2>Próximo paciente</h2>

                            <p>A fila ainda não está disponível para consulta.</p>

                        </article>

                        <p class="nota">Os dados de atendimento não estão conectados nesta versão da interface.</p>

                    <?php break;

                    case 'cadastro': ?>

                        <!-- Cadastro: nomes de campos e destino originais. -->

                        <div class="card formulario">

                            <h2>Dados do paciente</h2>

                            <p>Preencha todos os campos para solicitar o cadastro.</p>

                            <form action="cadastrarPaciente.php" method="post" class="form">

                                <?php if ($nomeCadastrado !== ''): ?>
                                    <p class="mensagem sucesso" role="status">
                                        Paciente: <?= escapar($nomeCadastrado) ?>, cadastrado!
                                    </p>
                                <?php endif; ?>

                                <div class="campo">

                                    <label for="nome">Nome completo</label>

                                    <input id="nome" type="text" name="nome" required autocomplete="name"

                                        placeholder="Ex.: Maria Souza">

                                </div>

                                <div class="campos-2">

                                    <div class="campo">

                                        <label for="cpf">CPF</label>

                                        <input id="cpf" type="text" name="cpf" required inputmode="numeric" pattern="[0-9]{11}"

                                            maxlength="11" placeholder="00000000000" aria-describedby="cpf-ajuda">

                                        <small id="cpf-ajuda">Somente os 11 números</small>

                                    </div>

                                    <div class="campo">

                                        <label for="tel">Telefone</label>

                                        <input id="tel" type="tel" name="telefone" required inputmode="numeric"

                                            pattern="[0-9]{10,11}" maxlength="11" autocomplete="tel" placeholder="71999990000"

                                            aria-describedby="tel-ajuda">

                                        <small id="tel-ajuda">DDD + número</small>

                                    </div>

                                </div>

                                <fieldset class="campo">

                                    <legend>Nível de gravidade</legend>

                                    <div class="gravidades">

                                        <label class="grav g1">

                                            <input type="radio" name="gravidade" value="1" required>

                                            <span class="grav-box"><b aria-hidden="true">1</b><strong>Pouco

                                                    urgente</strong><small>Setor 0 · Comum</small></span>

                                        </label>

                                        <label class="grav g2">

                                            <input type="radio" name="gravidade" value="2">

                                            <span class="grav-box"><b

                                                    aria-hidden="true">2</b><strong>Urgente</strong><small>Setor 1 ·

                                                    Clínica</small></span>

                                        </label>

                                        <label class="grav g3">

                                            <input type="radio" name="gravidade" value="3">

                                            <span class="grav-box"><b

                                                    aria-hidden="true">3</b><strong>Emergência</strong><small>Setor 2 ·

                                                    UTI</small></span>

                                        </label>

                                    </div>

                                </fieldset>

                                <button type="submit" class="btn btn-primario">Cadastrar paciente</button>

                            </form>

                        </div>

                    <?php break;

                    case 'fila': ?>

                        <div class="card">

                            <div class="card-topo">

                                <div>

                                    <h2>Pacientes aguardando</h2>

                                    <p>Quantidade indisponível</p>

                                </div>

                                <form action="index.php?tela=fila" method="post"><input type="hidden" name="acao"

                                        value="chamar"><button class="btn btn-primario">Chamar próximo paciente</button></form>

                            </div>

                            <p class="nota">Ordem de chegada, com precedência para nível 3. Entre emergências, mantém-se a ordem

                                de chegada.</p>

                            <div class="tabela-container" tabindex="0" role="region" aria-label="Fila de espera">

                                <table>

                                    <thead>

                                        <tr>

                                            <th>Posição</th>

                                            <th>Paciente</th>

                                            <th>Gravidade</th>

                                            <th>Entrada</th>

                                            <th>Situação</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <tr>

                                            <td colspan="5" class="vazio">Fila indisponível para consulta.</td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                            <!-- Quando o backend retornar uma fila vazia: Nenhum paciente aguardando atendimento. -->

                        </div>

                    <?php break;

                    case 'leitos': ?>

                        <p class="nota">Ocupação indisponível. Não há confirmação de leitos livres ou setores lotados.</p>

                        <div class="setores">

                            <?php foreach (['Atendimento comum', 'Observação / Clínica', 'Emergência / UTI'] as $numero => $setor): ?>

                                <article class="card">

                                    <p class="sobretitulo">Setor <?= $numero ?></p>

                                    <h2><?= $setor ?></h2>

                                    <p>Disponíveis: — · Ocupados: —</p>

                                    <!-- Posições do layout original; não representam ocupação confirmada. -->

                                    <ul class="leitos" aria-label="Posições de leitos sem dados de ocupação">

                                        <?php for ($leito = 0; $leito < 5; $leito++): ?>

                                            <li><strong>L<?= $leito ?></strong><small>Sem dados</small></li>

                                        <?php endfor; ?>

                                    </ul>

                                </article>

                            <?php endforeach; ?>

                        </div>

                        <div class="card">

                            <h2>Liberar leito</h2>

                            <p>Selecione o setor e o leito.</p>

                            <form action="index.php?tela=leitos" method="post" class="liberar">

                                <div class="campo"><label for="lib-setor">Setor</label><select id="lib-setor" name="setor">

                                        <option value="0">Setor 0 · Comum</option>

                                        <option value="1">Setor 1 · Clínica</option>

                                        <option value="2">Setor 2 · UTI</option>

                                    </select></div>

                                <div class="campo"><label for="lib-leito">Leito</label><select id="lib-leito"

                                        name="leito"><?php for ($i = 0; $i < 5; $i++): ?>

                                            <option value="<?= $i ?>">Leito <?= $i ?></option><?php endfor; ?>

                                    </select></div>

                                <input type="hidden" name="acao" value="liberar"><button class="btn">Liberar</button>

                            </form>

                        </div>

                    <?php break;

                    case 'busca': ?>

                        <div class="card formulario">

                            <h2>Consulta por CPF</h2>

                            <p>Informe os 11 números do CPF do paciente.</p>

                            <form action="buscaPaciente.php" method="get" class="form" role="search">

                                <input type="hidden" name="tela" value="busca"><input type="hidden" name="acao" value="buscar">

                                <div class="campo"><label for="busca-cpf">CPF</label><input id="busca-cpf" name="cpf"

                                        inputmode="numeric" pattern="[0-9]{11}" maxlength="11" required

                                        placeholder="00000000000" value="<?= escapar(parametro($_GET, 'cpf')) ?>"></div>

                                <button class="btn btn-primario">Buscar</button>

                            </form>

                            <p class="nota">A consulta de pacientes ainda não está disponível.</p>

                        </div>

                    <?php break;

                    case 'historico': ?>

                        <div class="card">

                            <div class="card-topo">

                                <div>

                                    <h2>Histórico do plantão</h2>

                                    <p>A ação mais recente aparece primeiro.</p>

                                </div>

                                <form action="index.php?tela=historico" method="post"><input type="hidden" name="acao"

                                        value="desfazer"><button class="btn">Desfazer última ação</button></form>

                            </div>

                            <p class="vazio">Histórico indisponível para consulta.</p>

                            <p class="nota">O desfazer depende da pilha de ações do sistema.</p>

                        </div>

                    <?php break;

                    case 'medicos': ?>

                        <div class="card">

                            <h2>Equipe médica</h2>

                            <div class="tabela-container" tabindex="0" role="region" aria-label="Equipe médica">

                                <table>

                                    <thead>

                                        <tr>

                                            <th>Nome</th>

                                            <th>Especialidade</th>

                                            <th>Setor</th>

                                            <th>Situação</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <tr>

                                            <td colspan="4" class="vazio">Equipe indisponível para consulta.</td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    <?php break;

                    case 'relatorios': ?>

                        <nav class="abas" aria-label="Tipos de relatório"><?php foreach ($abas as $chave => $rotulo): ?><a

                                    class="btn" href="index.php?tela=relatorios&amp;aba=<?= $chave ?>" <?= $aba === $chave ? ' aria-current="page"' : '' ?>><?= $rotulo ?></a><?php endforeach; ?></nav>

                        <div class="card">

                            <h2><?= escapar($abas[$aba]) ?></h2>

                            <?php if ($aba === 'ordenado'): ?>

                                <form action="index.php" method="get" class="acoes"><input type="hidden" name="tela"

                                        value="relatorios"><input type="hidden" name="aba" value="ordenado"><input type="hidden"

                                        name="acao" value="relatorio">

                                    <button class="btn" name="ordem" value="nome"

                                        aria-pressed="<?= $ordem === 'nome' ? 'true' : 'false' ?>">A–Z Nome</button><button

                                        class="btn" name="ordem" value="gravidade"

                                        aria-pressed="<?= $ordem === 'gravidade' ? 'true' : 'false' ?>">Gravidade</button>

                                </form>

                                <p class="vazio">Relatório indisponível. A ordenação depende dos dados do sistema.</p><a

                                    href="relatorio.html">Abrir página de relatórios →</a>

                            <?php elseif ($aba === 'distribuicao'): ?>

                                <p class="vazio">Distribuição por gravidade indisponível.</p>

                            <?php else: ?>

                                <p class="vazio">Estatísticas do dia indisponíveis.</p><?php endif; ?>

                        </div>

                <?php break;

                endswitch; ?>

            </section>

        </main>

        <footer><span>VitaCare · Projeto de Lógica de Programação</span><a href="feedback.html">Sobre o retorno do

                cadastro</a><small>Prof. Leonardo Lucena · Antonio Bernardo · Guilherme Linhares · João Pedro · Lucas

                Rafael</small></footer>

    </div>

</body>

</html>
