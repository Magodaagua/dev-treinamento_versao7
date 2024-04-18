<?php
// inclua sua conexão com o banco de dados e outras configurações necessárias
include_once "conexao.php";

// Receba os parâmetros da URL
$id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
$id_aula = filter_input(INPUT_GET, 'id_aula', FILTER_SANITIZE_NUMBER_INT);
$id_modulo = filter_input(INPUT_GET, 'modulo_id', FILTER_SANITIZE_NUMBER_INT);
$id_curso = filter_input(INPUT_GET, 'curso_id', FILTER_SANITIZE_NUMBER_INT);
$porcentagem_conclusao = filter_input(INPUT_GET, 'porcentagem', FILTER_SANITIZE_NUMBER_FLOAT);

// Verifique se o usuário já possui um registro na tabela progresso_aula para esta aula
$query_verificar = "SELECT * FROM progresso_aula WHERE id_usuario = :id_usuario AND id_aula = :id_aula";
$stmt_verificar = $con->prepare($query_verificar);
$stmt_verificar->bindParam(':id_usuario', $id_usuario); // você precisará obter o ID do usuário
$stmt_verificar->bindParam(':id_aula', $id_aula);
$stmt_verificar->execute();

if ($stmt_verificar->rowCount() > 0) {
    // O usuário já possui um registro, você pode redirecioná-lo para a página da aula
    header("Location: ../visualizar_aula.php?id=$id_aula&modulo_id=$id_modulo&curso_id=$id_curso&porcentagem=$porcentagem_conclusao");
    exit();
} else {
    // Se já existe um registro, atualiza, senão insere
    if ($stmt_verificar->rowCount() > 0) {
        // Atualiza o registro existente
        $query_update = "UPDATE progresso_aula SET concluida = 0 WHERE id_usuario = :id_usuario AND id_aula = :id_aula AND id_curso = :id_curso";
        $stmt_update = $con->prepare($query_update);
        $stmt_update->bindParam(':id_usuario', $id_usuario);
        $stmt_update->bindParam(':id_aula', $id_aula);
        $stmt_update->bindParam(':id_curso', $id_curso);
        $stmt_update->execute();
    } else {
        // Insere um novo registro
        $query_insert = "INSERT INTO progresso_aula (id_usuario, id_aula, id_curso, concluida) VALUES (:id_usuario, :id_aula, :id_curso, 0)";
        $stmt_insert = $con->prepare($query_insert);
        $stmt_insert->bindParam(':id_usuario', $id_usuario);
        $stmt_insert->bindParam(':id_aula', $id_aula);
        $stmt_insert->bindParam(':id_curso', $id_curso);
        $stmt_insert->execute();
    }

    // Redireciona o usuário para a página da aula
    header("Location: ../visualizar_aula.php?id=$id_aula&modulo_id=$id_modulo&curso_id=$id_curso&porcentagem=$porcentagem_conclusao");
    exit();
}
