<?php
    // conexao com o banco de dados
    include 'conexao.php';
   
    //retorna todas as informações do usuário no banco de dados
    $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
    $resultado_usuario = mysqli_query($conn, $result_usuario);

    // Verifique se id_grupo está presente em $_POST
    if (isset($_GET['id_grupo'])) {
        //salva o id passado pela url
        $id_grupo = $_GET['id_grupo'];

        //pega todas as informações do usuario
        while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
            $row_usuario['ID_usuario']."<br>";		
            $row_usuario['Senha']."<br>";

            $id_user = $row_usuario['ID_usuario'];
        }
        
        //seleciona todas as mensagens escritas no banco de dados
        $sql = "SELECT id, id_usuario, nome_usuario, id_grupo, mensagem, data_envio FROM mensagensgrupo WHERE id_grupo = $id_grupo ORDER BY data_envio DESC LIMIT 10";
        $result = $conn->query($sql);

        //se procurar no banco de dados e tiver um retorno
        if ($result->num_rows > 0) {
            $mensagens = array();
            while ($row = $result->fetch_assoc()) {
                $mensagens[] = $row;
            }
            // Inverter a ordem das mensagens
            $mensagens = array_reverse($mensagens);
            foreach ($mensagens as $row) {
                // Adicione classes específicas com base no tipo de usuário
                $messageClass = ($row["id_usuario"] == $id_user) ? "my-message" : "other-message";
                
                // Formatando a data e hora
                $dataFormatada = date('d/m/Y', strtotime($row["data_envio"]));
                $horaFormatada = date('H:i', strtotime($row["data_envio"]));
            
                // Adicione a classe correspondente à div de mensagem e exiba a data e a hora dentro do balão de fala
                echo "<div class='message-container'>";
                echo "<div class='message-balloon $messageClass'><strong>" . $row["nome_usuario"] . ":</strong> <div class='message-text'>" . $row["mensagem"] . "<br><span class='data'>$dataFormatada</span><span class='hora'>$horaFormatada</span></div></div>";
                echo "</div><br>";
            }        

            // Adicione uma função JavaScript para rolar automaticamente para o final da área de mensagens
            echo "<script>document.getElementById('messages-container').scrollTop = document.getElementById('messages-container').scrollHeight;</script>";
        //se não tiver um retorno do banco de dados
        } else {
            echo "<p>Nenhuma mensagem.</p>";
        }
    //se não pegar o ID do grupo
    } else {
        echo "Não pegou o ID do Grupo";
    }
?>
