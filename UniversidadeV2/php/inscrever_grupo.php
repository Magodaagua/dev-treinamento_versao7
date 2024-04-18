<?php
    include_once("conexao.php");

    // Verifica se o ID do grupo foi fornecido na URL junto com o id do usuário
    if(isset($_GET['id_grupo'])) {
        $id_grupo = $_GET['id_grupo'];
        $id_user = $_GET['id_user'];
        
        // Verifica se o usuário esta ou não esta inscrito
        $query_verificar = "SELECT * FROM inscricao_grupo WHERE id_cliente = $id_user AND id_grupo = $id_grupo";
        $resultado_verificar = mysqli_query($conn, $query_verificar);

        //retorna que o usuário não está inscrito
        if(mysqli_num_rows($resultado_verificar) == 0) {
            // Insere a inscrição na tabela inscricao_grupo
            $query_inserir = "INSERT INTO inscricao_grupo (id_cliente, id_grupo) VALUES ($id_user, $id_grupo)";
            $resultado_inserir = mysqli_query($conn, $query_inserir);

            //se conseguiu inserir com sucesso na tabela inscricao_grupo vai repassar para a página do grupo
            if($resultado_inserir) {
                echo '<script>window.location.href = "../salas.php?id_grupo=' . $id_grupo . '";</script>';
                echo "Inscrição realizada com sucesso!";
            // se não mata o processamento voltando um erro de inscrição
            } else {
                echo "Erro ao realizar a inscrição: " . mysqli_error($conn);
            }
        //retorna que o usuário já está inscrito no grupo
        } else {
            echo "Usuário já está inscrito neste grupo.";
        }
    //se não for fornecido dá erro
    } else {
        echo "ID do grupo não fornecido na URL.";
    }
?>
