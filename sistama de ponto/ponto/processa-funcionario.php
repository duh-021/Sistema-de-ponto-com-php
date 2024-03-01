<?php
session_start();
include_once("conexao.php");

if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
} else {
    echo "deu xabu";
    exit();
}

$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$empresa = filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_STRING);
$grade = filter_input(INPUT_POST, 'grade', FILTER_SANITIZE_NUMBER_INT);

$dados = "insert into usuario (nome, empresa, grade) values ('$nome','$empresa','$grade')";
$envia_dados = mysqli_query($conecta_db, $dados);

if(mysqli_insert_id($conecta_db)){

    header("location: cadastra-funcionario.php");
    $_SESSION['msg'] = "Usuario cadastrado";
    

}else{
    
    alert("erro");
    header("location: cadastra-funcionario.php");

}

?>