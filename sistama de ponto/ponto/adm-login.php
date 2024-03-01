<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/tela-login.css">
    <script src="js/login.js"></script>
</head>
<body>
    <img src="img/logo-compo2.png" class="logo"><br>
    <h5>Bem-vindo</h5>
    <text>Sistema de ponto Compo System</text>
    <h6>Sistema de ponto seguro e de fácil uso para sua empresa</h6>
    <a href="tela-inicial-ponto.php"> 
        <button class="vejamais">Voltar</button>
    </a>
    <h2>Login</h2>
    <div class="iconegeral">
        <h4> Login digite seu usuário e senha.</h4>
        <form method="POST" action="valida-senha.php">
            <input id="usuario" name="nome" type="text" class="usuario" placeholder="Usuario">
            <img src="img/perfil-de-usuario.png" class="icone1"><br>
            <input id="senha" name="senha" class="senha" type="password" placeholder="Senha" >
            <img src="img/trancar.png" class="icone2"><br>
            <button id="logar" type="submit">Logar</button>
        </form>
        <script></script>
        <h3>Esqueci acesso</h3>
    </div>
    <img src="img/olho.png" id="icone3" class="icone3">
    <div class="conteiner"></div>
            <h6 class="dev">Developer By CompoSystem</h6>

<script>
    var img = document.querySelector("#icone3");
    var input = document.querySelector('#senha');

        img.onclick = function() {

            if (input.getAttribute('type') === 'password') {
                input.setAttribute('type', 'text');
                img.setAttribute('src', 'img/olho2.png');
            } else {
                input.setAttribute('type', 'password');
                img.setAttribute('src', 'img/olho.png');
            }

        };


var tempoInatividade = 20000; // 20 segundos

var temporizadorInatividade;

function reiniciarTemporizador() {

  clearTimeout(temporizadorInatividade);

  // Define o temporizador novamente
  temporizadorInatividade = setTimeout(function () {
    // Redireciona para adm.php após o tempo de inatividade
    window.location.href = 'inicio.php';
  }, tempoInatividade);
}

// Adicione eventos para rastrear a atividade do usuário
document.addEventListener('mousemove', reiniciarTemporizador);
document.addEventListener('keydown', reiniciarTemporizador);

// Inicie o temporizador inicial
reiniciarTemporizador();

</script>


    </body>
</html>
