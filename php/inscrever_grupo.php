<?php
include_once("conexao.php");

// Verifica se o ID do grupo foi fornecido na URL
if(isset($_GET['id_grupo'])) {
    $id_grupo = $_GET['id_grupo'];
    $id_user = $_GET['id_user'];
    
    // Verifica se o usuário já não está inscrito
    $query_verificar = "SELECT * FROM inscricao_grupo WHERE id_cliente = $id_user AND id_grupo = $id_grupo";
    $resultado_verificar = mysqli_query($conn, $query_verificar);

    if(mysqli_num_rows($resultado_verificar) == 0) {
        // Insere a inscrição na tabela inscricao_grupo
        $query_inserir = "INSERT INTO inscricao_grupo (id_cliente, id_grupo) VALUES ($id_user, $id_grupo)";
        $resultado_inserir = mysqli_query($conn, $query_inserir);

        if($resultado_inserir) {
            echo '<script>window.location.href = "../salas.php?id_grupo=' . $id_grupo . '";</script>';
            echo "Inscrição realizada com sucesso!";
        } else {
            echo "Erro ao realizar a inscrição: " . mysqli_error($conn);
        }
    } else {
        echo "Usuário já está inscrito neste grupo.";
    }
} else {
    echo "ID do grupo não fornecido na URL.";
}
?>
