<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');


// Inicializa $row_funcionarios
$row_funcionarios = null;

// Verifica se o ID do usuário foi passado na URL
if (isset($_GET['id'])) {
    $id_usuario_clicado = $_GET['id'];

    // Faça a conexão com o banco de dados (substitua com suas configurações)
    include_once("conexao.php");

    // Consulta para obter dados específicos do usuário com base no ID
    $query_usuario = "SELECT id, nome, empresa FROM usuario WHERE id = :id";
    $stmt_usuario = $conecta_db->prepare($query_usuario);
    $stmt_usuario->bindParam(':id', $id_usuario_clicado);
    $stmt_usuario->execute();

    // Verifica se o usuário foi encontrado
    if ($stmt_usuario->rowCount() > 0) {
        $row_funcionarios = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Não encontrou o usuário.";
    }
} else {
    echo "ID não foi passado na URL.";
    // Você pode redirecionar o usuário ou realizar alguma outra ação aqui.
}


// Verifica se $row_funcionarios não é nulo antes de acessar seus valores
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="css/index.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
</head>

<body>
    <style>
        body {
            font-family: 'Roboto';
        }
    </style>

    <img src="http://localhost/ponto/img/logo-compo2.png" class="logo"><br>

    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <div class="conteiner">
        <img class="foto" src="http://localhost/ponto/img/user.png">

        <h2 class="nome"><?php echo ($row_funcionarios ? "" . $row_funcionarios['nome'] : "Nome não disponível"); ?></h2>
        <h2 class="empresa"><?php echo ($row_funcionarios ? "" . $row_funcionarios['empresa'] : "Empresa não disponível"); ?></h2>

        <h2 class="nr"><?php echo ($row_funcionarios ? "Nr:" . $row_funcionarios['id'] : "Número não disponível"); ?></h2>
        <p id="horario" class="relogio"><?php echo date("H:i:s") ?></p>
        <p class="data"><?php echo date("d/m/y") ?></p>

        <form action="http://localhost/ponto/tela-inicial-ponto.php">
            <button type="submit" class="voltar">⭠</button><br>
        </form>

        <form action="registrar_ponto.php?id_usuario=<?php echo $id_usuario_clicado; ?>" method="post">

            <button type="submit" class="registrar">REGISTRAR</button><br>
        </form>

        <?php echo "<a class='grade' href='http://localhost/ponto/puxa_grade.php?id=" . $row_funcionarios['id'] . "'>Listar grade</a>"; ?>
        <h6 class="dev">Developer By CompoSystem</h6>

        <script>
            // Seu código JavaScript aqui
        </script>

    </div>
</body>

</html>


        <script>
            var apHorario = document.getElementById("horario");

            function atualiza() {
                var data = new Date().toLocaleTimeString("pt-br", {
                    timeZone: "America/Sao_Paulo"
                });
                apHorario.innerHTML = data;
            }

            setInterval(atualiza, 1000);

            var tempoInatividade = 30000; // 30 segundos

            var temporizadorInatividade;

            function reiniciarTemporizador() {
                clearTimeout(temporizadorInatividade);

                temporizadorInatividade = setTimeout(function () {
                    window.location.href = 'http://localhost/ponto/inicio.php';
                }, tempoInatividade);
            }

            document.addEventListener('mousemove', reiniciarTemporizador);
            document.addEventListener('keydown', reiniciarTemporizador);

            reiniciarTemporizador();
        </script>

    </div>
</body>

</html>
