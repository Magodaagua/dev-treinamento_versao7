<?php
    include_once("conexao.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperando dados do formulário
        $nomeSala = mysqli_real_escape_string($conn, $_POST['nomeSala']);
        $categoriaSala = mysqli_real_escape_string($conn, $_POST['categoriaSala']);
        $privacidade = $_POST['privacidade'];
        $idUsuario = $_POST['idusuario'];

        // ID do usuário (você pode recuperar isso da sessão do usuário)
        //$idUsuario = 1; // Substitua pelo método adequado de obter o ID do usuário

        // Inserindo dados na tabela grupo
        $query = "INSERT INTO salas (id_admin_grupo, Nome_grupo, Categoria, Privado) VALUES ('$idUsuario', '$nomeSala', '$categoriaSala', '$privacidade')";
        //$query_inserir = "INSERT INTO inscricao_grupo (id_cliente, id_grupo) VALUES ($id_user, $id_grupo)"; 
    
        if (mysqli_query($conn, $query)) {
            // Grupo criado com sucesso
            header("Location: ../grupo.php"); // Redireciona para a página inicial após criar a sala
            exit();
        } else {
            echo "Erro ao criar a sala: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
?>
