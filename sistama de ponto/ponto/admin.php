<?php include('validaSessao.php');
?>

<html>
<head>
    <link rel="stylesheet" href="css/admin.css">
    <link href='https://fonts.googleapis.com/css?family=arial' rel='stylesheet'>

</head>
<style>body{font-family:'arial';}</style>
<body>
<img src="img/logo-compo2.png" class="logo"><br>
<?php echo "<h3 class='logado'>Bem vindo ".$_SESSION['nome']."</h3>"?>
<h5>Painel geral de configurações para administrador</h5>
<a href="cadastra-admin.php"><div class="conteiner"><img class="cadastra" src="img/cadeado.png"><h3>Cadastrar Login</h3></a>
<a href="cadastra-funcionario.php"><div class="conteiner"><img class="cadastra" src="img/cadastro.png"><h3>funcionario</h3></a>
<a href="lista-funcionario.php"><div class="conteiner"><img class="cadastra" src="img/listar.png"><h3>Listar funcionario</h3></a>

<form method="POST" action="derrubaSessao.php"><button class="sair" type="submit">Sair</button></form>
<h6 class="dev">Developer By CompoSystem</h6>

</body>
</html>