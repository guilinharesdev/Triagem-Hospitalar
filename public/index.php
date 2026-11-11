<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="color-scheme" content="light dark">
  <meta name="theme-color" content="#eef2f7" media="(prefers-color-scheme: light)">
  <meta name="theme-color" content="#0a1322" media="(prefers-color-scheme: dark)">
  <title>Painel · VitaCare Triagem Hospitalar</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<a href="#conteudo" class="pular">Pular para o conteúdo</a>

<!-- Checkbox que abre/fecha o menu no celular (sem JavaScript) -->
<input type="checkbox" id="menu-toggle" class="menu-toggle" aria-label="Abrir ou fechar o menu">

<div class="app">

  <!-- ============ MENU LATERAL ============ -->
  <aside class="sidebar" aria-label="Menu principal">
    <div class="logo">
      <span class="logo-icone" aria-hidden="true">✚</span>
      <div>
        <strong>VitaCare</strong>
        <small>Triagem Hospitalar</small>
      </div>
    </div>

    <nav class="nav" aria-label="Seções do sistema">
      <p class="nav-titulo">Principal</p>
      <a href="#inicio" class="ativo" aria-current="page"><span aria-hidden="true">📊</span> Painel</a>
      <a href="#cadastro"><span aria-hidden="true">📝</span> Cadastrar paciente</a>
      <a href="#fila"><span aria-hidden="true">⏳</span> Fila de espera <em class="badge">8<span class="sr"> pacientes</span></em></a>
      <a href="#leitos"><span aria-hidden="true">🛏️</span> Mapa de leitos</a>

      <p class="nav-titulo">Consultas</p>
      <a href="#busca"><span aria-hidden="true">🔍</span> Buscar por CPF</a>
      <a href="relatorio.html"><span aria-hidden="true">📋</span> Relatórios</a>
      <a href="#historico"><span aria-hidden="true">🕘</span> Histórico</a>
      <a href="#medicos"><span aria-hidden="true">🩺</span> Médicos</a>
    </nav>

    <div class="plantao">
      <span class="pulso" aria-hidden="true"></span>
      <div>
        <strong>Plantão ativo</strong>
        <small>Noturno · 19h às 07h</small>
      </div>
    </div>
  </aside>

  <label for="menu-toggle" class="overlay" aria-hidden="true"></label>

  <!-- ============ CONTEÚDO ============ -->
  <div class="conteudo">

    <header class="topbar">
      <label for="menu-toggle" class="hamburguer" aria-hidden="true"><span></span><span></span><span></span></label>
      <div class="topbar-titulo">
        <h1>Painel do plantão</h1>
        <p><time datetime="2026-10-29">Quinta-feira, 29 de outubro de 2026</time></p>
      </div>
      <div class="usuario">
        <div class="avatar" aria-hidden="true">RC</div>
        <div class="usuario-info">
          <strong>Recepção Central</strong>
          <small>Triagem</small>
        </div>
      </div>
    </header>

    <main id="conteudo">

      <!-- Banner -->
      <section id="inicio" class="hero" aria-labelledby="hero-titulo">
        <div>
          <span class="hero-tag">Plantão em andamento</span>
          <h2 id="hero-titulo">Atendimento rápido começa com uma triagem organizada.</h2>
          <p>Cadastre pacientes, acompanhe a fila por prioridade e direcione cada um ao leito certo em segundos.</p>
          <div class="hero-botoes">
            <a href="#cadastro" class="btn btn-branco">+ Novo paciente</a>
            <a href="#fila" class="btn btn-vidro">Ver fila</a>
          </div>
        </div>
        <div class="hero-proximo">
          <p class="proximo-rotulo">Próximo a ser chamado</p>
          <div class="proximo-card">
            <div class="avatar grande g3-bg" aria-hidden="true">CM</div>
            <div>
              <strong>Carlos Mendes</strong>
              <span class="pill g3"><b aria-hidden="true">3</b>Emergência · Nível 3</span>
              <small>Aguardando há 4 min</small>
            </div>
          </div>
          <!-- PHP: mostrar este aviso só quando o setor do próximo paciente estiver lotado -->
          <p class="aviso-lotado"><span aria-hidden="true">⚠</span> Setor 2 sem leito livre</p>
          <form action="index.php" method="post">
            <input type="hidden" name="acao" value="chamar">
            <button type="submit" class="btn btn-branco largo">Chamar e alocar leito →</button>
          </form>
        </div>
      </section>

      <!-- ====== ALERTA: SETOR LOTADO ======
           PHP: exibir somente quando o setor do próximo paciente da fila
           não tiver nenhum leito livre (regra do README). -->
      <section class="alerta" role="alert" aria-labelledby="alerta-titulo">
        <span class="alerta-icone" aria-hidden="true">!</span>
        <div>
          <h2 id="alerta-titulo">Setor 2 · Emergência/UTI está lotado</h2>
          <p>O próximo paciente, <strong>Carlos Mendes</strong> (Emergência · Nível 3), ainda não pode ser alocado: os 5 leitos do setor estão ocupados. Libere um leito do Setor 2 para continuar.</p>
        </div>
        <a href="#leitos" class="btn btn-alerta">Ir para o mapa de leitos</a>
      </section>

      <!-- Indicadores -->
      <section class="kpis" aria-labelledby="kpis-titulo">
        <h2 id="kpis-titulo" class="sr">Indicadores do dia</h2>
        <article class="kpi">
          <div class="kpi-icone azul" aria-hidden="true">👥</div>
          <div><span class="kpi-num">24</span><span class="kpi-rot">Cadastrados hoje</span></div>
          <span class="kpi-trend sobe"><span class="sr">Variação: </span>+12%</span>
        </article>
        <article class="kpi">
          <div class="kpi-icone verde" aria-hidden="true">✅</div>
          <div><span class="kpi-num">16</span><span class="kpi-rot">Atendidos</span></div>
          <span class="kpi-trend sobe"><span class="sr">Taxa: </span>67%</span>
        </article>
        <article class="kpi">
          <div class="kpi-icone amarelo" aria-hidden="true">⏳</div>
          <div><span class="kpi-num">8</span><span class="kpi-rot">Na fila agora</span></div>
          <span class="kpi-trend"><span class="sr">Espera média: </span>~12 min</span>
        </article>
        <article class="kpi">
          <div class="kpi-icone rosa" aria-hidden="true">🛏️</div>
          <div><span class="kpi-num">10<small>/15</small></span><span class="kpi-rot">Leitos ocupados</span></div>
          <div class="barra" aria-hidden="true"><span style="width:67%"></span></div>
        </article>
      </section>

      <div class="grade">

        <!-- ====== CADASTRO ====== -->
        <section id="cadastro" class="card" aria-labelledby="cadastro-titulo">
          <div class="card-topo">
            <div>
              <h2 id="cadastro-titulo">Cadastrar paciente</h2>
              <p>Preencha os dados para inserir na fila</p>
            </div>
            <span class="card-icone azul" aria-hidden="true">📝</span>
          </div>

          <form action="cadastrarPaciente.php" method="post" class="form">
            <?php
              if (isset($_GET['nome'])) {
            ?>    
            <p class='link-mais'>Paciente: <?php echo($_GET['nome']); ?>, cadastrado!
            <?php
              }
            ?>          

            <div class="campo">
              <label for="nome">Nome completo</label>
              <input id="nome" type="text" name="nome" required autocomplete="name" placeholder="Ex.: Maria Souza">
            </div>

            <div class="campos-2">
              <div class="campo">
                <label for="cpf">CPF</label>
                <input id="cpf" type="text" name="cpf" required inputmode="numeric" pattern="[0-9]{11}" maxlength="11" placeholder="00000000000" aria-describedby="cpf-ajuda">
                <small id="cpf-ajuda">Somente os 11 números</small>
              </div>
              <div class="campo">
                <label for="tel">Telefone</label>
                <input id="tel" type="tel" name="telefone" required inputmode="numeric" pattern="[0-9]{10,11}" maxlength="11" autocomplete="tel" placeholder="71999990000" aria-describedby="tel-ajuda">
                <small id="tel-ajuda">DDD + número</small>
              </div>
            </div>

            <fieldset class="campo">
              <legend>Nível de gravidade</legend>
              <div class="gravidades">
                <label class="grav g1">
                  <input type="radio" name="gravidade" value="1" required>
                  <span class="grav-box"><b aria-hidden="true">1</b><strong>Pouco urgente</strong><small>Setor 0 · Comum</small></span>
                </label>
                <label class="grav g2">
                  <input type="radio" name="gravidade" value="2">
                  <span class="grav-box"><b aria-hidden="true">2</b><strong>Urgente</strong><small>Setor 1 · Clínica</small></span>
                </label>
                <label class="grav g3">
                  <input type="radio" name="gravidade" value="3">
                  <span class="grav-box"><b aria-hidden="true">3</b><strong>Emergência</strong><small>Setor 2 · UTI</small></span>
                </label>
              </div>
            </fieldset>

            <button type="submit" class="btn btn-primario largo">Cadastrar e enviar para a fila</button>
          </form>
        </section>

        <!-- ====== FILA ====== -->
        <section id="fila" class="card" aria-labelledby="fila-titulo">
          <div class="card-topo">
            <div>
              <h2 id="fila-titulo">Fila de espera</h2>
              <p>Emergências passam à frente</p>
            </div>
            <span class="contador">8 pacientes</span>
          </div>

          <ol class="fila">
            <li class="paciente g3">
              <span class="pos" aria-hidden="true">1</span>
              <div class="avatar g3-bg" aria-hidden="true">CM</div>
              <div class="pac-info"><strong>Carlos Mendes</strong><small>CPF 111.222.333-44 · 19:42</small></div>
              <span class="pill g3"><b aria-hidden="true">3</b><span class="pill-texto">Emergência</span></span>
            </li>
            <li class="paciente g3">
              <span class="pos" aria-hidden="true">2</span>
              <div class="avatar g3-bg" aria-hidden="true">RA</div>
              <div class="pac-info"><strong>Rita Alves</strong><small>CPF 333.444.555-66 · 19:44</small></div>
              <span class="pill g3"><b aria-hidden="true">3</b><span class="pill-texto">Emergência</span></span>
            </li>
            <li class="paciente g2">
              <span class="pos" aria-hidden="true">3</span>
              <div class="avatar g2-bg" aria-hidden="true">AP</div>
              <div class="pac-info"><strong>Ana Paula</strong><small>CPF 222.333.444-55 · 19:31</small></div>
              <span class="pill g2"><b aria-hidden="true">2</b><span class="pill-texto">Urgente</span></span>
            </li>
            <li class="paciente g2">
              <span class="pos" aria-hidden="true">4</span>
              <div class="avatar g2-bg" aria-hidden="true">FN</div>
              <div class="pac-info"><strong>Fábio Nunes</strong><small>CPF 444.555.666-77 · 19:38</small></div>
              <span class="pill g2"><b aria-hidden="true">2</b><span class="pill-texto">Urgente</span></span>
            </li>
            <li class="paciente g1">
              <span class="pos" aria-hidden="true">5</span>
              <div class="avatar g1-bg" aria-hidden="true">JL</div>
              <div class="pac-info"><strong>João Lima</strong><small>CPF 987.654.321-00 · 19:35</small></div>
              <span class="pill g1"><b aria-hidden="true">1</b><span class="pill-texto">Pouco urgente</span></span>
            </li>
          </ol>
          <a href="relatorio.html" class="link-mais">Ver fila completa →</a>
        </section>

        <!-- ====== LEITOS ====== -->
        <section id="leitos" class="card card-largo" aria-labelledby="leitos-titulo">
          <div class="card-topo">
            <div>
              <h2 id="leitos-titulo">Mapa de leitos</h2>
              <p>Matriz de ocupação por setor</p>
            </div>
            <div class="legenda" aria-hidden="true">
              <span><i class="dot livre"></i> Livre</span>
              <span><i class="dot ocupado"></i> Ocupado</span>
            </div>
          </div>

          <div class="setores">
            <div class="setor s0">
              <div class="setor-topo">
                <h3><span class="setor-num">Setor 0</span>Atendimento comum</h3>
                <span class="setor-ocup"><span class="sr">Ocupação: </span>2/5</span>
              </div>
              <ul class="leitos">
                <li class="leito livre"><span aria-hidden="true">🛏️</span><small>L0</small><span class="sr">livre</span></li>
                <li class="leito ocupado"><span aria-hidden="true">🛏️</span><small>L1</small><span class="sr">ocupado</span></li>
                <li class="leito livre"><span aria-hidden="true">🛏️</span><small>L2</small><span class="sr">livre</span></li>
                <li class="leito livre"><span aria-hidden="true">🛏️</span><small>L3</small><span class="sr">livre</span></li>
                <li class="leito ocupado"><span aria-hidden="true">🛏️</span><small>L4</small><span class="sr">ocupado</span></li>
              </ul>
            </div>

            <div class="setor s1">
              <div class="setor-topo">
                <h3><span class="setor-num">Setor 1</span>Observação / Clínica</h3>
                <span class="setor-ocup"><span class="sr">Ocupação: </span>3/5</span>
              </div>
              <ul class="leitos">
                <li class="leito ocupado"><span aria-hidden="true">🛏️</span><small>L0</small><span class="sr">ocupado</span></li>
                <li class="leito ocupado"><span aria-hidden="true">🛏️</span><small>L1</small><span class="sr">ocupado</span></li>
                <li class="leito livre"><span aria-hidden="true">🛏️</span><small>L2</small><span class="sr">livre</span></li>
                <li class="leito ocupado"><span aria-hidden="true">🛏️</span><small>L3</small><span class="sr">ocupado</span></li>
                <li class="leito livre"><span aria-hidden="true">🛏️</span><small>L4</small><span class="sr">livre</span></li>
              </ul>
            </div>

            <!-- Classe "lotado" quando não há leito livre no setor -->
            <div class="setor s2 lotado">
              <div class="setor-topo">
                <h3><span class="setor-num">Setor 2</span>Emergência / UTI</h3>
                <span class="setor-ocup lotado"><span class="sr">Ocupação: </span>5/5 · Lotado</span>
              </div>
              <ul class="leitos">
                <li class="leito ocupado"><span aria-hidden="true">🛏️</span><small>L0</small><span class="sr">ocupado</span></li>
                <li class="leito ocupado"><span aria-hidden="true">🛏️</span><small>L1</small><span class="sr">ocupado</span></li>
                <li class="leito ocupado"><span aria-hidden="true">🛏️</span><small>L2</small><span class="sr">ocupado</span></li>
                <li class="leito ocupado"><span aria-hidden="true">🛏️</span><small>L3</small><span class="sr">ocupado</span></li>
                <li class="leito ocupado"><span aria-hidden="true">🛏️</span><small>L4</small><span class="sr">ocupado</span></li>
              </ul>
            </div>
          </div>

          <form action="index.php" method="post" class="liberar" aria-labelledby="liberar-titulo">
            <span id="liberar-titulo" class="liberar-titulo">Liberar leito</span>
            <label for="lib-setor" class="sr">Setor</label>
            <select id="lib-setor" name="setor">
              <option value="0">Setor 0 · Comum</option>
              <option value="1">Setor 1 · Clínica</option>
              <option value="2">Setor 2 · UTI</option>
            </select>
            <label for="lib-leito" class="sr">Leito</label>
            <select id="lib-leito" name="leito">
              <option value="0">Leito 0</option><option value="1">Leito 1</option>
              <option value="2">Leito 2</option><option value="3">Leito 3</option>
              <option value="4">Leito 4</option>
            </select>
            <input type="hidden" name="acao" value="liberar">
            <button type="submit" class="btn btn-escuro">Liberar</button>
          </form>
        </section>

        <!-- ====== BUSCA + RELATÓRIO ====== -->
        <section id="busca" class="card" aria-labelledby="busca-titulo">
          <div class="card-topo">
            <div>
              <h2 id="busca-titulo">Buscar paciente</h2>
              <p>Pesquisa por CPF</p>
            </div>
            <span class="card-icone roxo" aria-hidden="true">🔍</span>
          </div>

          <form action="index.php" method="get" class="busca" role="search">
            <input type="hidden" name="acao" value="buscar">
            <label for="busca-cpf" class="sr">CPF do paciente</label>
            <input id="busca-cpf" type="text" name="cpf" inputmode="numeric" pattern="[0-9]{11}" maxlength="11" placeholder="Digite o CPF (11 números)" required>
            <button type="submit" class="btn btn-primario">Buscar</button>
          </form>

          <div class="resultado" role="status">
            <div class="avatar g3-bg" aria-hidden="true">MS</div>
            <div>
              <strong>Maria Souza</strong>
              <small>CPF 123.456.789-00 · (71) 99999-0000</small>
              <small>Setor 2 · Leito 2 · <b class="ok">Atendida</b></small>
            </div>
          </div>

          <div id="relatorio" class="relatorio">
            <h3>Relatório ordenado</h3>
            <form action="index.php" method="get" class="segmentado">
              <input type="hidden" name="acao" value="relatorio">
              <button type="submit" name="ordem" value="nome">A–Z Nome</button>
              <button type="submit" name="ordem" value="gravidade">Gravidade</button>
            </form>
            <a href="relatorio.html" class="link-mais">Abrir relatório completo →</a>
          </div>
        </section>

        <!-- ====== HISTÓRICO ====== -->
        <section id="historico" class="card" aria-labelledby="historico-titulo">
          <div class="card-topo">
            <div>
              <h2 id="historico-titulo">Histórico do plantão</h2>
              <p>Última ação no topo</p>
            </div>
            <span class="card-icone amarelo" aria-hidden="true">🕘</span>
          </div>

          <ul class="timeline">
            <li class="t-chamada">
              <time datetime="19:45">19:45</time>
              <div><strong>Paciente chamado</strong><small>Maria Souza → Setor 2, Leito 2</small></div>
            </li>
            <li class="t-cadastro">
              <time datetime="19:44">19:44</time>
              <div><strong>Novo cadastro</strong><small>Rita Alves · Nível 3</small></div>
            </li>
            <li class="t-libera">
              <time datetime="19:40">19:40</time>
              <div><strong>Leito liberado</strong><small>Setor 1, Leito 4</small></div>
            </li>
            <li class="t-cadastro">
              <time datetime="19:38">19:38</time>
              <div><strong>Novo cadastro</strong><small>Fábio Nunes · Nível 2</small></div>
            </li>
          </ul>

          <form action="index.php" method="post">
            <input type="hidden" name="acao" value="desfazer">
            <button type="submit" class="btn btn-contorno largo"><span aria-hidden="true">↶</span> Desfazer última ação</button>
          </form>
        </section>

        <!-- ====== MÉDICOS ====== -->
        <section id="medicos" class="card" aria-labelledby="medicos-titulo">
          <div class="card-topo">
            <div>
              <h2 id="medicos-titulo">Equipe médica</h2>
              <p>4 médicos de plantão</p>
            </div>
            <span class="card-icone verde" aria-hidden="true">🩺</span>
          </div>

          <ul class="medicos">
            <li>
              <div class="avatar med1"><span aria-hidden="true">PR</span><i class="status on"></i></div>
              <div class="medico-info"><strong>Dr. Paulo Ribeiro</strong><small>Clínica geral · <span class="sr">status: </span>disponível</small></div>
              <span class="tag-esp">Setor 0</span>
            </li>
            <li>
              <div class="avatar med2"><span aria-hidden="true">HC</span><i class="status on"></i></div>
              <div class="medico-info"><strong>Dra. Helena Costa</strong><small>Cardiologia · <span class="sr">status: </span>disponível</small></div>
              <span class="tag-esp">Setor 1</span>
            </li>
            <li>
              <div class="avatar med3"><span aria-hidden="true">MS</span><i class="status ocupado"></i></div>
              <div class="medico-info"><strong>Dr. Marcos Silva</strong><small>Emergência · <span class="sr">status: </span>em atendimento</small></div>
              <span class="tag-esp">Setor 2</span>
            </li>
            <li>
              <div class="avatar med4"><span aria-hidden="true">JL</span><i class="status on"></i></div>
              <div class="medico-info"><strong>Dra. Júlia Lopes</strong><small>Pediatria · <span class="sr">status: </span>disponível</small></div>
              <span class="tag-esp">Setor 0</span>
            </li>
          </ul>
        </section>

        <!-- ====== GRAVIDADE DO DIA ====== -->
        <section id="distribuicao" class="card card-largo" aria-labelledby="dist-titulo">
          <div class="card-topo">
            <div>
              <h2 id="dist-titulo">Pacientes por gravidade</h2>
              <p>Distribuição dos 24 cadastros de hoje</p>
            </div>
          </div>
          <div class="barras">
            <div class="barra-linha">
              <span class="rot"><i class="dot g1" aria-hidden="true"></i> Pouco urgente</span>
              <div class="trilho" aria-hidden="true"><span class="g1-bg" style="width:50%"></span></div>
              <b>12</b>
            </div>
            <div class="barra-linha">
              <span class="rot"><i class="dot g2" aria-hidden="true"></i> Urgente</span>
              <div class="trilho" aria-hidden="true"><span class="g2-bg" style="width:29%"></span></div>
              <b>7</b>
            </div>
            <div class="barra-linha">
              <span class="rot"><i class="dot g3" aria-hidden="true"></i> Emergência</span>
              <div class="trilho" aria-hidden="true"><span class="g3-bg" style="width:21%"></span></div>
              <b>5</b>
            </div>
          </div>
        </section>

      </div>
    </main>

    <footer class="rodape">
      <p><strong>VitaCare</strong> · Projeto de Lógica de Programação · Prof. Leonardo Lucena</p>
      <p>Antonio Bernardo · Guilherme Linhares · João Pedro · Lucas Rafael</p>
    </footer>
  </div>
</div>

</body>
</html>
