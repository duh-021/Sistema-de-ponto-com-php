<?php 
session_start();

if (isset($_POST['usuario'], $_POST['senha'])){
    if($_POST['usuario']=='maria' && $_POST['senha']=='123'){
        $_SESSION['usuario'] = $_POST['usuario'];
        header('location:clientes.php');
    }
}

?>
<form action='' method='post'>
    <input type="text" name="usuario" placeholder="usuario">
    <input type="text" name="senha" placeholder="senha">
    <input type="submit" name="login" value="login">


</form>