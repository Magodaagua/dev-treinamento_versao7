<?php
    include 'conexao.php'; // Inclua o arquivo de conexão

    // Verifique se os dados estão sendo recebidos
    if (isset($_POST['usuario'], $_POST['nome'], $_POST['mensagem'], $_POST['tipo'])) {
        $usuario = $_POST['usuario'];
        $nome = $_POST['nome'];
        $mensagem = $_POST['mensagem'];
        $tipo = $_POST['tipo'];

        $id_admin = 1;

        // Use declarações preparadas para evitar injeção de SQL
        $stmt = $conn->prepare("INSERT INTO mensagens (usuario, nome_usuario, mensagem, tipo, id_admin) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $usuario, $nome, $mensagem, $tipo, $id_admin);

        if ($stmt->execute()) {
            echo "Mensagem enviada com sucesso!";
        } else {
            echo "Erro ao enviar mensagem: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Dados incompletos.";
    }
?>
