<?php
session_start();
include("registrar_ponto.php");

?>

<!DOCTYPE html>
<head></head>
<body>
<div class='conteiner2'>
    <h1 class='registro'>horario de $text_tipo_registro cadastrado!<h1>
    <h1 class='hora'>$horario_atual</h1><br>
    <h1 class='data'>$data_entrada</h1>

        <form action='http://localhost/ponto/tela-inicial-ponto.php'>
            
                <input class='botao' type='submit' value='OK'>
            </dvi>
        </form>
    <style>
        h1{
            color: black;
        }
        .registro{

        }
        .hora1{

        }
        .data2{
            font-size: 60px;
            margin-top: auto;
            color: rgb(0, 0, 0);
            font-weight: bold;
            text-align: center;
            left: -100px;

        }
        .botao{

            background-color: red;
        }
        .conteiner2{

            border-radius: 10px;
            width: 600px;
            height: 200px;
            margin-bottom: -200px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            background-color:red;
            position: relative;



        }
    
    </style>
    </body>
</html>