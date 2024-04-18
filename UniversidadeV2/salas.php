<!doctype html>
<html lang="pt-br">
	<?php
        //Conexão com o banco de dados
        include_once("php/conexao.php");

        //pega o id do usuário e do grupo passado pela URL
        $id_user = isset($_GET['id_user']) ? $_GET['id_user'] : null;
        $id_grupo = isset($_GET['id_grupo']) ? $_GET['id_grupo'] : null;

        //faz uma busca no banco de dados para coletar algumas inforamções do usuário e salva-las em variáveis
        $result_usuario = "SELECT * FROM usuario WHERE ID_usuario = '$id_user' ";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
            $row_usuario['ID_usuario']."<br>";		
            $row_usuario['Senha']."<br>"; 

        $id_user = $row_usuario['ID_usuario'];
        $nome = $row_usuario['Nome'];
        $id_grupo = $_GET['id_grupo'];
        $dep = $row_usuario['Dep'];
        $nome_usuario = $row_usuario['Nome'];
        $abreviacao = $row_usuario['Abreviacao'];

        //faz uma busca no banco de dados para coletar todas as informações deste grupo
        $result_grupo = "SELECT * FROM salas WHERE ID_grupo = '$id_grupo'";
        $resultado_grupo = mysqli_query($conn, $result_grupo);
        while($row_grupo = mysqli_fetch_assoc($resultado_grupo)){
            $row_grupo['ID_grupo']."<br>";
            $row_grupo['Nome_grupo']."<br>";		

            $id_grupo1 = $row_grupo['ID_grupo'];
            $nome_grupo = $row_grupo['Nome_grupo'];
        }
	?>
   <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <!-- Titulo da página-->
        <title>Grupo de Estudos - <?php echo $nome_grupo; ?></title>

        <!--coloca o icone na aba da tela-->
        <link rel="icon" type="png" href="../../COMUM/img/Icons/Vermelho/imgML13.png">

        <!--CSS-->
        <link rel="stylesheet" href="css/tudo.css">

    </head>
    <body>
        <!-- menu superior -->
        <?php 
            require "titulo.php"; 
        ?>
        <br>
        <!-- espaço da sala de chat e do menu lateral que mostra os participantes -->
        <div class="chatsala">
            <!-- Sala de chat -->
            <div class="chat-container">
                    <!-- titulo da sala de chat -->
                    <div class="chat-header">
                        <span>Chat do grupo</span>
                    </div>
                    <!-- Mostrador de mensagens da sala de chat -->
                    <div class="messages-container" id="messages-container"></div>
                    <!-- Formulário de envio de mensagens -->
                    <form id="chat-form" class="chat-form">
                        <input type="hidden" id="usuario" value="<?php echo $id_user; ?>">
                        <input type="hidden" id="nome" value="<?php echo $nome; ?>">
                        <input type="hidden" id="id_grupo" value="<?php echo $id_grupo; ?>">
                        <button id="emoji-button">😀</button>
                        <div id="emoji-popup" class="emoji-popup" style="display: none;">
                            <div class="emoji-content">
                                <span class="emoji" onclick="insertEmoji('😀')">😀</span>
                                <span class="emoji" onclick="insertEmoji('😊')">😊</span>
                                <!-- Adicione mais emojis conforme necessário -->
                            </div>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="mensagem" placeholder="Digite sua mensagem">
                        <button type="submit">Enviar</button>
                    </form>
                </div>
                <!-- menu lateral que mostra os participantes -->
                <div class="participants-container" id="participants-container">
                    <!-- titulo do menu lateral -->
                    <div class="chat-header">Membros do Grupo</div>
                    <!-- Lista de participantes -->
                    <?php

                        // Query para selecionar o nome do administrador do grupo
                        $query_admin = "SELECT Nome_grupo, id_admin_grupo FROM salas WHERE ID_grupo = $id_grupo";
                        $result_admin = mysqli_query($conn, $query_admin);
                        $row_admin = mysqli_fetch_assoc($result_admin);
                        $nome_admin = $row_admin['Nome_grupo'];

                        // Query para selecionar os usuários que participam do grupo
                        $query_participantes = "SELECT u.Nome FROM usuario u 
                                                INNER JOIN inscricao_grupo ig ON u.ID_usuario = ig.id_cliente
                                                WHERE ig.id_grupo = $id_grupo";

                        // Executar a consulta
                        $result_participantes = mysqli_query($conn, $query_participantes);

                        // Verificar se há participantes
                        if(mysqli_num_rows($result_participantes) > 0) {
                            // Exibir a lista de participantes
                            while($row_participante = mysqli_fetch_assoc($result_participantes)) {
                                echo "<div class='Nomedousuario'>" . $row_participante['Nome'] . "</div>";
                            }
                        } else {
                            echo "<div>Nenhum participante encontrado.</div>";
                        }

                        // Fechar conexão com o banco de dados
                        mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
        <!-- javascript que faz a parte de mensagens que aparecem na sala de chat funcionar -->
        <script>
            document.getElementById('chat-form').addEventListener('submit', function (e) {
                e.preventDefault();

                // ... (código para enviar a mensagem)
                var usuario = document.getElementById('usuario').value;
                var nome = document.getElementById('nome').value;
                var id_grupo = document.getElementById('id_grupo').value;
                var mensagem = document.getElementById('mensagem').value;

                // Adicione a identificação única do cliente à requisição
                var cliente_id = 'coloqueAquiOIDUnicoDoCliente';  // Substitua pelo ID único do cliente com quem o suporte está interagindo
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'php/enviar_mensagem_grupo.php', true);
                        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState == 4 && xhr.status == 200) {
                                // Processar a resposta do servidor, se necessário
                                console.log(xhr.responseText);
                                // Atualizar mensagens após o envio bem-sucedido
                                carregarMensagens();
                            }
                        };

                        xhr.send('usuario=' + encodeURIComponent(usuario) + '&nome=' + encodeURIComponent(nome) + '&id_grupo=' + encodeURIComponent(id_grupo) + '&mensagem=' + encodeURIComponent(mensagem));

                        // Limpar campo de mensagem após envio
                        document.getElementById('mensagem').value = '';

                // Role para a última mensagem
                var messagesContainer = document.getElementById('messages-container');
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            });

            // Variável global para armazenar o status da rolagem
            var scrolledToBottom = true;

            // Função para verificar se a área de mensagens está rolada para baixo
            function isScrolledToBottom(element) {
                return element.scrollHeight - element.clientHeight <= element.scrollTop + 1;
            }

            // Função para carregar mensagens do servidor
            function carregarMensagens(id_grupo) {
                var messagesContainer = document.getElementById('messages-container');
                var shouldScrollToBottom = isScrolledToBottom(messagesContainer);

                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'php/exibir_mensagens_grupo.php?id_grupo=' + '<?php echo $id_grupo1; ?>', true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Atualizar o conteúdo do contêiner de mensagens
                        document.getElementById('messages-container').innerHTML = xhr.responseText;
                        
                        // Rolagem automática apenas se o usuário já estava no final da página
                        if (shouldScrollToBottom) {
                            messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        }
                    }
                };
                xhr.send();
            }

            // Carregar mensagens ao carregar a página
            document.addEventListener('DOMContentLoaded', carregarMensagens);
            // Atualizar mensagens apenas se o usuário estiver no final da página
            setInterval(function() {
                if (scrolledToBottom) {
                    // Chamar a função carregarMensagens() com o id_grupo
                    carregarMensagens('<?php echo $id_grupo1; ?>');
                }
            }, 5000);

            // Atualizar status de rolagem quando o usuário rolar a área de mensagens
            document.getElementById('messages-container').addEventListener('scroll', function() {
                scrolledToBottom = isScrolledToBottom(this);
            });

            document.getElementById('emoji-button').addEventListener('click', function() {
            var emojiPopup = document.getElementById('emoji-popup');
            if (emojiPopup.style.display === 'none') {
                emojiPopup.style.display = 'block';
            } else {
                emojiPopup.style.display = 'none';
            }
            });

            function insertEmoji(emoji) {
                var mensagemInput = document.getElementById('mensagem');
                mensagemInput.value += emoji;
                var emojiPopup = document.getElementById('emoji-popup');
                emojiPopup.style.display = 'none';
            }
        </script>
        <!-- rodapé -->
        <?php 
            }
            require "rodape.php"; 
        ?>
        <!-- javascript -->
        <script src="js/darkmode.js"></script>
        <script src="js/zoom.js"></script>
    </body>
</html>