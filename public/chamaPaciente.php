  <?php 
   include('../src/fila.php');

   $proximoPacienteProLeito = chamarPaciente();
   //var_dump($proximoPacienteProLeito);

   include('../src/pilha.php');

   verPaciente();
   header('Location: index.php?tela=fila');exit;