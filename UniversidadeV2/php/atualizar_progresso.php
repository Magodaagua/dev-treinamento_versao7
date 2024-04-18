<?php
    // Inclua a conexão com o banco de dados
    include_once "conexao.php"; // Certifique-se de ajustar o caminho do arquivo de conexão conforme necessário
    // Recupere os parâmetros da página atual
    $id_usuario = filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_NUMBER_INT);
    $id_curso = filter_input(INPUT_POST, 'id_curso', FILTER_SANITIZE_NUMBER_INT);
    $id_modulo = filter_input(INPUT_POST, 'modulo_id', FILTER_SANITIZE_NUMBER_INT);
    $id_aula = filter_input(INPUT_POST, 'id_aula', FILTER_SANITIZE_NUMBER_INT);
    $porcentagem = filter_input(INPUT_POST, 'porcentagem', FILTER_SANITIZE_NUMBER_FLOAT);

    // Atualize o campo 'concluida' para 1 na tabela progresso_aula
    $query_update = "UPDATE progresso_aula SET concluida = 1 WHERE id_usuario = :id_usuario AND id_aula = :id_aula AND id_curso = :id_curso";
    $stmt_update = $con->prepare($query_update);
    $stmt_update->bindParam(':id_usuario', $id_usuario);
    $stmt_update->bindParam(':id_aula', $id_aula);
    $stmt_update->bindParam(':id_curso', $id_curso);
    $stmt_update->execute();

    // Redireciona o usuário para a página da aula
    header("Location: ../visualizar_aula.php?id_user=$id_usuario&id=$id_aula&modulo_id=$id_modulo&curso_id=$id_curso&porcentagem=$porcentagem");
    exit();

?>