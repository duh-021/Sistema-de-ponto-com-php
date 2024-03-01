<?php
include_once("conexao.php");
include('validaSessao.php');
?>



<body>
    <link rel="stylesheet" href="css/cadastro.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <img src="img/logo-compo2.png" class="logo"><br>
    <div class="conteiner">


<h2 class="titulo">Cadastrar um Admin</h2>
    <?php
    if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>
   
    <style>input{font-family:'Roboto';}h1{font-family:'Roboto';}h2{font-family:'Roboto';}h6{font-family:'Roboto';}</style>
    <form class="registro" method="POST" action="processa-adm.php"> 
    
    <input name="nome" class="nome" placeholder="Nome do usuario" ></input><br>
    <input name="senha" class="empresa" placeholder="Senha"></input><br>     
    <input class="cadastrar" value="Registrar" type="submit"></input><br>

</form>
<div>
<a href="admin.php"><input class="voltar" value="⭠" type="submit"></input><a>

<h6 class="dev">Developer By CompoSystem</h6>

</body>
</html>
