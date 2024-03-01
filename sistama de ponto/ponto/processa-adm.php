<?php
session_start();
include_once("conexao.php");

$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$empresa = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

$dados = "insert into loginn (nome, senha) values ('$nome','$empresa')";
$envia_dados = mysqli_query($conecta_db, $dados);

if(mysqli_insert_id($conecta_db)){

    header("location: cadastra-admin.php");
    $_SESSION['msg'] = "Administrador cadastrado";
    

}else{
    
    alert("erro");
    header("location: cadastra-funcionario.php");

}

?>