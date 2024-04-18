<!doctype html>
<html lang="pt-br">
    <!-- Conexão com o banco de dados -->
	<?php
        include_once("php/conexao.php");

        $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
            $row_usuario['ID_usuario']."<br>";		
            $row_usuario['Senha']."<br>"; 

        $id_user = $row_usuario['ID_usuario'];
        $nome = $row_usuario['Nome'];
        $dep = $row_usuario['Dep'];
        $nome_usuario = $row_usuario['Nome'];

	?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>Portal de Cursos - Suporte</title>

        <!-- Bootstrap core CSS -->
        <!--<link href="css/bootstrap.min.css" rel="stylesheet">-->

        <!--coloca o icone na aba da tela-->
        <link rel="icon" type="png" href="../COMUM/img/Icons/Vermelho/copi.png">

        <!--CSS -->
        <link rel="stylesheet" type="text/css" href="css/titulo.css">
        <link rel="stylesheet" type="text/css" href="css/suporte.css">
        <link href="https://fonts.cdnfonts.com/css/community" rel="stylesheet">
        <!--<link href="css/curso.css" rel="stylesheet">-->
    </head>
    <body>
    <?php require "titulo.php"; ?>
        <?php }?> 
        <main>
            <h1><br><br><br>
                <center>Suporte</center>
            </h1><br>
            <center>
                <div class="chat-container">
                    <div class="chat-header">
                        <span>Chat com o Suporte</span>
                    </div>
                    <div class="messages-container" id="messages-container"></div>
                    <form id="chat-form" class="chat-form">
                        <input type="hidden" id="usuario" value="<?php echo $id_user; ?>">
                        <input type="hidden" id="nome" value="<?php echo $nome; ?>">
                        <input type="text" id="mensagem" placeholder="Digite sua mensagem">
                        <input type="hidden" id="tipo" value="cliente">
                        <button class="botaosuporte" type="submit">Enviar</button>
                    </form>
                </div>
            </center>

            <script>
                document.getElementById('chat-form').addEventListener('submit', function (e) {
                    e.preventDefault();

                    // ... (código para enviar a mensagem)
                    var usuario = document.getElementById('usuario').value;
                    var nome = document.getElementById('nome').value;
                    var mensagem = document.getElementById('mensagem').value;
                    var tipo = document.getElementById('tipo').value;

                    // Adicione a identificação única do cliente à requisição
                    var cliente_id = 'coloqueAquiOIDUnicoDoCliente';  // Substitua pelo ID único do cliente com quem o suporte está interagindo
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'php/enviar_mensagem.php', true);
                            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                            xhr.onreadystatechange = function () {
                                if (xhr.readyState == 4 && xhr.status == 200) {
                                    // Processar a resposta do servidor, se necessário
                                    console.log(xhr.responseText);
                                    // Atualizar mensagens após o envio bem-sucedido
                                    carregarMensagens();
                                }
                            };

                            xhr.send('usuario=' + encodeURIComponent(usuario) + '&nome=' + encodeURIComponent(nome) + '&mensagem=' + encodeURIComponent(mensagem) + '&tipo=' + encodeURIComponent(tipo));

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
                    xhr.open('GET', 'php/exibir_mensagens.php', true);
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

                // Atualizar mensagens a cada 5 segundos (por exemplo)
                setInterval(carregarMensagens, 5000);
                // Atualizar mensagens apenas se o usuário estiver no final da página
                setInterval(function() {
                    if (scrolledToBottom) {
                        // Chamar a função carregarMensagens() com o id_grupo
                        carregarMensagens();
                    }
                }, 5000);

            </script>

            <!--inicio Botão de voltar ao topo-->
            <button id="myBtn" title="Go to top">Subir</button>
        </main>
        <script src="javascript/subir.js"></script> 
        <script src="javascript/darkmode.js"></script>
    </body>
</html>