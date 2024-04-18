<?php
    //conexão banco de dados
    include 'conexao.php';

    // Verifique se os dados estão sendo recebidos
    if (isset($_POST['usuario'], $_POST['nome'], $_POST['mensagem'], $_POST['tipo'])) {
        $usuario = $_POST['usuario'];
        $nome = $_POST['nome'];
        $mensagem = $_POST['mensagem'];
        $tipo = $_POST['tipo'];

        $id_admin = 1;

        // cria no banco de dados as mensagens para o bate papo com o suporte
        $stmt = $conn->prepare("INSERT INTO mensagens (usuario, nome_usuario, mensagem, tipo, id_admin) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $usuario, $nome, $mensagem, $tipo, $id_admin);

        //se enviou a mensagem e salvou com sucesso no banco de dados
        if ($stmt->execute()) {
            echo "Mensagem enviada com sucesso!";
        //se não conseguiu enviar e salvar no banco de dados
        } else {
            echo "Erro ao enviar mensagem: " . $stmt->error;
        }

        $stmt->close();
    // se não foi recebi dado algum
    } else {
        echo "Dados incompletos.";
    }
?>
