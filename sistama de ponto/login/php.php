<?php
include("registrar_ponto.php");

?>
<html>
    <body>
        <div class='conteiner2'>
                <h1 class='registro'><br>Horario de <?php echo "$text_tipo_registro  Registrado!<br><h1 class='complemento'>$text_complemento</h1><h1>";?>
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
</html>