<?php

// Incluir o arquivo com a conexão com banco de dados
include_once 'conexao.php';

// Receber o ID da aula
$aula_id = filter_input(INPUT_GET, 'aula_id', FILTER_SANITIZE_NUMBER_INT);
// Receber o ID da modulo
$modulo_id= filter_input(INPUT_GET, 'modulo_id', FILTER_SANITIZE_NUMBER_INT);
// Receber o ID do curso
$curso_id= filter_input(INPUT_GET, 'curso_id', FILTER_SANITIZE_NUMBER_INT);

// Definir fuso horário de São Paulo
date_default_timezone_set('America/Sao_Paulo');

// Acessar o IF quando é selecionado ao menos uma estrela
if (!empty($_POST['estrela'])) {

    // Receber os dados do formulário
    $estrela = filter_input(INPUT_POST, 'estrela', FILTER_DEFAULT);
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_DEFAULT);

    // Criar a QUERY cadastrar no banco de dados
    $query_avaliacao = "INSERT INTO avaliacoes (qtd_estrela, mensagem, created, aula_id, modulo_id, curso_id) VALUES (:qtd_estrela, :mensagem, :created, :aula_id, :modulo_id, :curso_id)";

    // Preparar a QUERY
    $cad_avaliacao = $con->prepare($query_avaliacao);

    // Substituir os links pelo valor
    $cad_avaliacao->bindParam(':qtd_estrela', $estrela, PDO::PARAM_INT);
    $cad_avaliacao->bindParam(':mensagem', $mensagem, PDO::PARAM_STR);
    $cad_avaliacao->bindParam(':created', date("Y-m-d H:i:s"));
    $cad_avaliacao->bindParam(':aula_id', $aula_id, PDO::PARAM_INT);
    $cad_avaliacao->bindParam(':modulo_id', $modulo_id, PDO::PARAM_INT);
    $cad_avaliacao->bindParam(':curso_id', $curso_id, PDO::PARAM_INT);

    // Acessa o IF quando cadastrar corretamente
    if ($cad_avaliacao->execute()) {

        // Criar a mensagem de erro
        $_SESSION['msg'] = "<p style='color: green;'>Avaliação cadastrar com sucesso.</p>";

        // Redirecionar o usuário para a página inicial
        header("Location: ../visualizar_aula.php?id=$aula_id&modulo_id=$modulo_id&curso_id=$curso_id");
    } else {

        // Criar a mensagem de erro
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Avaliação não cadastrar.</p>";

        // Redirecionar o usuário para a página inicial
        header("Location: ../visualizar_aula.php?id=$aula_id&modulo_id=$modulo_id&curso_id=$curso_id");
    }
} else {

    // Criar a mensagem de erro
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário selecionar pelo menos 1 estrela.</p>";

    // Redirecionar o usuário para a página inicial
    header("Location: ../visualizar_aula.php?id=$aula_id&modulo_id=$modulo_id&curso_id=$curso_id");
}

?>