<?php
    //conecta o banco de dados
    include 'conexao.php';
   
    //pega todas as informações do usuário atual
    $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
    $resultado_usuario = mysqli_query($conn, $result_usuario);
    while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
       $row_usuario['ID_usuario']."<br>";		
       $row_usuario['Senha']."<br>";

    $id_user = $row_usuario['ID_usuario'];
    }

    //faz uma pesquisa no banco de dados para retornar todas as mensagens enviadas naquele grupo
    $sql = "SELECT usuario, nome_usuario, mensagem, data_envio, tipo, id_admin FROM mensagens WHERE usuario = $id_user ORDER BY data_envio DESC LIMIT 10";
    $result = $conn->query($sql);
    //se tiver um retorno da pesquisa 
    if ($result->num_rows > 0) {
        $mensagens = array();
        while ($row = $result->fetch_assoc()) {
            $mensagens[] = $row;
        }
        // Inverter a ordem das mensagens
        $mensagens = array_reverse($mensagens);
        foreach ($mensagens as $row) {
            // Adicione classes específicas com base no tipo de usuário
            if ($row["usuario"] != '0') {
                $classeUsuario = ($row["tipo"] == "suporte") ? "suporte" : "cliente";
                // Formatando a data e hora
                $dataFormatada = date('d/m/Y', strtotime($row["data_envio"]));
                $horaFormatada = date('H:i', strtotime($row["data_envio"]));
                echo "<div class='message-balloon $classeUsuario'><strong>" . $row["nome_usuario"] . ":</strong> " . $row["mensagem"] . "<br><span class='data'>$dataFormatada</span><span class='hora'>$horaFormatada</span></div>";
            } else {
                $classeUsuario = ($row["tipo"] == "suporte") ? "suporte" : "cliente";
                // Formatando a data e hora
                $dataFormatada = date('d/m/Y', strtotime($row["data_envio"]));
                $horaFormatada = date('H:i', strtotime($row["data_envio"]));
                echo "<div class='message-balloon $classeUsuario'><strong> Suporte:</strong> " . $row["mensagem"] . "<br><span class='data'>$dataFormatada</span><span class='hora'>$horaFormatada</span></div>";
            }
        }

        // Adicione uma função JavaScript para rolar automaticamente para o final da área de mensagens
        echo "<script>document.getElementById('messages-container').scrollTop = document.getElementById('messages-container').scrollHeight;</script>";
    //se não tiver retorno a pesquisa feita anteriormente
    } else {
        echo "<p>Nenhuma mensagem.</p>";
    }
?>
