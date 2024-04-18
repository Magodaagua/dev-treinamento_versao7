<?php
    include 'conexao.php'; // Inclua o arquivo de conexão

    // Verifique se os dados estão sendo recebidos
    if (isset($_POST['usuario'], $_POST['nome'], $_POST['id_grupo'] ,$_POST['mensagem'])) {
        $usuario = $_POST['usuario'];
        $nome = $_POST['nome'];
        $id_grupo = $_POST['id_grupo'];
        $mensagem = $_POST['mensagem'];

        if($mensagem != ''){
            // Use declarações preparadas para evitar injeção de SQL
            $stmt = $conn->prepare("INSERT INTO mensagensgrupo (id_usuario, nome_usuario,id_grupo, mensagem) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $usuario, $nome, $id_grupo, $mensagem);

            if ($stmt->execute()) {
                echo "Mensagem enviada com sucesso!";
            } else {
                echo "Erro ao enviar mensagem: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
        echo "Dados incompletos.";
    }
?>
