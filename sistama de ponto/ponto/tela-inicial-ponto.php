<?php
session_start();
include_once("conexao.php");
?>
<html>
    <head>
        <link rel="stylesheet" href="css/style_main.css">
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <header>
            <a href="inicio.php"><img class="logo" src="img/logo-compo3.png"></img></a>
        </header>
    </head>
    <body>
<script>

  var tempoInatividade = 20000; // 20 segundos

  var temporizadorInatividade;

  function reiniciarTemporizador() {

    clearTimeout(temporizadorInatividade);

    // Define o temporizador novamente
    temporizadorInatividade = setTimeout(function () {
      // Redireciona para adm.php após o tempo de inatividade
      window.location.href = 'inicio.php';
    }, tempoInatividade);
  }

  // Adicione eventos para rastrear a atividade do usuário
  document.addEventListener('mousemove', reiniciarTemporizador);
  document.addEventListener('keydown', reiniciarTemporizador);

  // Inicie o temporizador inicial
  reiniciarTemporizador();
</script>

        <style>
            body{font-family:'arial';}
        </style>
<?php
    $pega_dado = "SELECT * FROM usuario";
    $resultado_funcionarios = mysqli_query($conecta_db, $pega_dado);
    while ($row_funcionarios = mysqli_fetch_assoc($resultado_funcionarios)) {
      echo "<a href='http://localhost/login/index.php?id=" . $row_funcionarios['id'] . "'><div class='conteiner'></a>";
      echo "<a href='http://localhost/login/index.php?id=" . $row_funcionarios['id'] . "'><h4 class='nome'><img class='user' src='img/user.png'>" . $row_funcionarios['nome'] . "</img></h4></a>";
      echo "<a href='http://localhost/login/index.php?id=" . $row_funcionarios['id'] . "'><h4 class='od_registro'>Nr: " . $row_funcionarios['id'] . "</h4></a>";
  }
?> 
<a href="adm-login.php"><h3 class="opcoes">⁝ Mais Configurações</h3></a>

</body>
</html>