<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <link rel="stylesheet" href="css/inicio.css">
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
  <link href='https: //fonts.googleapis.com/css2?family=Black+Ops+One' rel="stylesheet">

  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      margin: 50px;
      font-size: 2em;
    }

    #relogio {
      margin-bottom: 20px;
      font-family: 'arial';
    }
    .data{
        font-family: 'arial';
    }
  </style>
</head>
<img class="logo" src="img/logo-compo.png"></img>

<body>
<div class="hora" id="relogio"></div>
<div class="data" id="data"></div>

<script>
  function atualizarRelogio() {
    var agora = new Date();

    var dia = agora.getDate().toString().padStart(2, '0');
    var mes = (agora.getMonth() + 1).toString().padStart(2, '0');
    var ano = agora.getFullYear();

    var horas = agora.getHours().toString().padStart(2, '0');
    var minutos = agora.getMinutes().toString().padStart(2, '0');
    var segundos = agora.getSeconds().toString().padStart(2, '0');

    var formatoData = dia + '/' + mes + '/' + ano;
    var formatoHora = horas + ':' + minutos + ':' + segundos;

    document.getElementById('relogio').textContent = formatoHora;
    document.getElementById('data').textContent = formatoData;

    // Verifica se é 03:00:00 para redirecionar para registra_ponto.php
    if (horas === '03' && minutos === '00' && segundos === '00') {
        window.location.href = 'http://localhost/login/verificahr.php';
    }

    setTimeout(atualizarRelogio, 1000);
  }

  document.addEventListener('DOMContentLoaded', function() {
    atualizarRelogio();

    // Adiciona um evento de clique ao corpo da página
    document.body.addEventListener('click', function() {
      // Redireciona para 123.php
      window.location.href = 'tela-inicial-ponto.php';
    });
  });
</script>
<h4><img class="touch" src="img/touch.png"></img>Toque na tela para proseguir</h4>
<h6 class="dev">Developer By CompoSystem</h6>
</body>
</html>
