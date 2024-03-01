<?php include("validaSessao.php"); 
include_once("conexao.php");

    $pega_dado = "SELECT * FROM ponto WHERE usuario_id";
    $resultado_funcionarios = mysqli_query($conecta_db, $pega_dado);
    while ($row_funcionarios = mysqli_fetch_assoc($resultado_funcionarios)) {
      echo "<hr><h1>Funcionario:" . $row_funcionarios['usuario_id']." <br></h1>";
      echo "<h3>Dia:" . $row_funcionarios['data_entrada']."</h3><br>";
      echo "entrada:" . $row_funcionarios['entrada']." <br>";
      echo "saida:" . $row_funcionarios['saida_intervalo']." <br>";
      echo "entrada:" . $row_funcionarios['retorno_intervalo']." <br>";
      echo "saida:" . $row_funcionarios['saida']." <br>";
      
  }
?> 