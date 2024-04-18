<?php
    //conexão com banco de dados
    include 'conexao.php';

    // Verifique se os dados estão sendo recebidos
    if (isset($_POST['usuario'], $_POST['nome'], $_POST['id_grupo'] ,$_POST['mensagem'])) {
        $usuario = $_POST['usuario'];
        $nome = $_POST['nome'];
        $id_grupo = $_POST['id_grupo'];
        $mensagem = $_POST['mensagem'];

        // se o campo mensagem não for vazio
        if($mensagem != ''){
            // insere na tabela mensagensgrupo a mensagem que o usuário escreveu neste grupo
            $stmt = $conn->prepare("INSERT INTO mensagensgrupo (id_usuario, nome_usuario,id_grupo, mensagem) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $usuario, $nome, $id_grupo, $mensagem);

            //se tudo ocorrer bem mensagem enviada com sucesso
            if ($stmt->execute()) {
                echo "Mensagem enviada com sucesso!";
            //se não erro no envio
            } else {
                echo "Erro ao enviar mensagem: " . $stmt->error;
            }

            $stmt->close();
        }
    // se não receber todos os dados para cadastrar a mensagem no grupo
    } else {
        echo "Dados incompletos.";
    }
?>
