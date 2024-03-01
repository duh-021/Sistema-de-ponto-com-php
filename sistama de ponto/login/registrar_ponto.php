<?php
session_start();
ob_start();
date_default_timezone_set('America/Sao_Paulo');

// Verifica se o ID do usuário está presente na URL
if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
} else {
    echo "deu xabu";
    exit();
}

$horario_atual = date("H:i:s");

$data_entrada = date('Y/m/d');

include_once("conexao.php");

$query_ponto = "SELECT id, saida_intervalo, retorno_intervalo, saida
                FROM ponto
                WHERE usuario_id = :usuario_id
                ORDER BY id DESC
                LIMIT 1";

$result_ponto = $conecta_db->prepare($query_ponto);

$result_ponto->bindParam(':usuario_id', $id_usuario);

$result_ponto->execute();

$roberto = 1;
if (($result_ponto) and ($result_ponto->rowCount() != 0)) {
    $row_ponto = $result_ponto->fetch(PDO::FETCH_ASSOC);
    extract($row_ponto);

    if (($saida_intervalo == "") or ($saida_intervalo == null)) {
        $col_tipo_registro = "saida_intervalo";
        $tipo_registro = "editar";
        $text_tipo_registro = "Saída intervalo";
        $text_complemento = "Bom almoço!";
    } elseif (($retorno_intervalo == "") or ($retorno_intervalo == null)) {
        $col_tipo_registro = "retorno_intervalo";
        $tipo_registro = "editar";
        $text_tipo_registro = "retorno do intervalo";
        $text_complemento = "Bom retorno!";
    } elseif (($saida == "") or ($saida == null)) {
        $col_tipo_registro = "saida";
        $tipo_registro = "editar";
        $text_tipo_registro = "saida";
        $text_complemento = "Bom descanso";
    } else {
        $tipo_registro = "entrada";
        $text_tipo_registro = "entrada";
        $text_complemento = "Bom dia!";
    }
} else {
    $tipo_registro = "entrada";
    $text_tipo_registro = "entrada";
}

switch ($tipo_registro) {
    case "editar";
        $query_horario = "UPDATE ponto SET  $col_tipo_registro =:horario_atual
                            WHERE id=:id
                            LIMIT 1";
        $cad_horario = $conecta_db->prepare($query_horario);
        $cad_horario->bindParam(':horario_atual', $horario_atual);
        $cad_horario->bindParam(':id', $id);
        break;
    
    default:
        $query_horario = "INSERT INTO ponto (data_entrada, entrada, usuario_id) VALUES (:data_entrada, :entrada, :usuario_id)";
        $cad_horario = $conecta_db->prepare($query_horario);
        $cad_horario->bindParam(':data_entrada', $data_entrada);
        $cad_horario->bindParam(':entrada', $horario_atual);
        $cad_horario->bindParam(':usuario_id', $id_usuario);
        break;
}

$cad_horario->execute();

if ($cad_horario->rowCount()) {

    $_SESSION['msg'] ="

<html>
    <body>
        <div class='conteiner2'>
                <h1 class='registro'><br>Horario de $text_tipo_registro  Registrado!<br><h1 class='complemento'>$text_complemento</h1><h1>
                <h1 class='hora1'>$horario_atual</h1><br>
                <h1 class='data'>$data_entrada</h1>
                    <form action='http://localhost/ponto/tela-inicial-ponto.php'>
                        <input class='botao' type='submit' value='OK'>
                    </form>
        </div><br> 
        <style>
            body{
                background-color:rgb(202, 202, 202);
            }
            h1{
                color: black;
            }
            .complemento{
                text-size:18px;

                text-align: center;

            }
            .registro{
                margin-top:160px;
                top: 20px;
                font-size:45px;
                text-align: center;
            }
            .hora1{
                font-size: 60px;
                margin-top: auto;
                color: rgb(0, 0, 0);
                font-weight: bold;
                text-align: center;
                left: -100px;
            }
            .data2{
                font-size: 60px;
                margin-top: auto;
                color: rgb(0, 0, 0);
                font-weight: bold;
                text-align: center;
                left: -100px;
                margin-bottom: -30px;

            }
            .botao{
                width: 150px;
                height:40px;
                background-color: rgb(0, 255, 132);
                margin-left: 220px;
                margin-right: auto;
                top: 100px;
                bottom: 30px;
                border: none;
                border-radius: 15px;
                font-size:25px;

            }
            .conteiner2{

                border-radius: 10px;
                width: 600px;
                height: 500px;
                margin-bottom: -200px;
                margin-left: auto;
                margin-right: auto;
                box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
                background-color: rgb(255, 255, 255);
                position: relative;
                border-radius: 15px;

            }
        </style>
    </body>
</html>";
header("location:http://localhost/login/index.php?id=".$id_usuario);
}else{
    $_SESSION['msg'] = "horario de $text_tipo_registro nao cadastrado";
}