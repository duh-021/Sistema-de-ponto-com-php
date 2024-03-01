<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

// Inclua o arquivo de conexão com o banco de dados
include_once("conexao.php");

// Obtém o horário atual
$horario_atual = date("H:i:s");

// Consulta para selecionar todos os registros de ponto
$query_ponto = "SELECT id, usuario_id, saida_intervalo, retorno_intervalo, saida
                FROM ponto";
$result_ponto = $conecta_db->query($query_ponto);

if ($result_ponto) {
    // Iterar sobre os resultados
    while ($row_ponto = $result_ponto->fetch(PDO::FETCH_ASSOC)) {
        extract($row_ponto);

        // Verificar e atualizar os registros conforme necessário
        if (($saida_intervalo == "" || $saida_intervalo == null)) {
            $saida_intervalo = '03:00:00';
        } elseif (($retorno_intervalo == "" || $retorno_intervalo == null)) {
            $retorno_intervalo = '03:00:00';
        } elseif (($saida == "" || $saida == null)) {
            $saida = '03:00:00';
        }
        // Atualizar o registro de ponto no banco de dados
        $query_update = "UPDATE ponto 
                         SET saida_intervalo = :saida_intervalo, retorno_intervalo = :retorno_intervalo, saida = :saida
                         WHERE id = :id";
        $update_ponto = $conecta_db->prepare($query_update);
        $update_ponto->bindParam(':saida_intervalo', $saida_intervalo);
        $update_ponto->bindParam(':retorno_intervalo', $retorno_intervalo);
        $update_ponto->bindParam(':saida', $saida);
        $update_ponto->bindParam(':id', $id);
        $update_ponto->execute();

        header("Location: http://localhost/ponto/inicio.php");

    }

}