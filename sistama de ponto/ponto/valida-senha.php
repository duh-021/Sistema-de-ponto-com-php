<?php
session_start();
include_once("conexao.php");

// Verifique se os dados foram enviados através do formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Captura os dados do formulário
    $nome = $_POST["nome"]; // Nome de usuário
    $senha = $_POST["senha"]; // Senha

    // Evite usar diretamente as variáveis na consulta para prevenir SQL Injection
    $sql = "SELECT nome, senha FROM loginn WHERE nome = ? AND senha = ?";
    $stmt = $conecta_db->prepare($sql);
    $stmt->bind_param("ss", $nome, $senha);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nome_db, $senha_db);
        $stmt->fetch();

        $_SESSION['nome'] = $nome_db;
        header("location: admin.php");

        // Verificando a senha
        if (password_verify($senha, $senha_db)) {
            echo "Senhas coincidem! Login bem-sucedido!";

 // Certifique-se de encerrar a execução após redirecionar
        } else {

            echo "Login falhou: Senha incorreta!";

        }
    } else {
        echo "Login falhou: Usuário não encontrado!";
    }

    $stmt->close();
} else {
    // Se não houver dados no formulário, exibir uma mensagem ou redirecionar para a página de formulário
    echo "Por favor, forneça dados através do formulário.";
}

$conecta_db->close();
?>