<!DOCTYPE html>
<html lang="pt-br">
    <?php
        //conexão banco de dados 
        include_once("php/conexao.php");

        //pesquisa todas as informações do usuário
        $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
        $resultado_usuario = mysqli_query($conn, $result_usuario);

        //salva as informações do usuário em variaveis
        if ($row_usuario = mysqli_fetch_assoc($resultado_usuario)) {
            $id_user = $row_usuario['ID_usuario'];
            $dep = $row_usuario['Dep'];
            $nome_usuario = $row_usuario['Nome'];
            $abreviacao = $row_usuario['Abreviacao'];
        }
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Suporte Versão 2</title>
        <!--coloca o icone na aba da tela-->
        <link rel="icon" type="png" href="../../COMUM/img/Icons/Vermelho/imgML13.png">
        <!--CSS-->
        <link href="https://fonts.cdnfonts.com/css/community" rel="stylesheet">
        <link rel="stylesheet" href="css/tudo.css">
    </head>
    <body>
        <!--menu superior-->
        <?php 
            require "titulo.php"; 
        ?>
        <!-- titulo da página-->
        <div class="suportetitulo">
            Suporte
        </div>
        <!--espaço que o chat ocupa-->
        <div class="suportechat">
            <!--corpo do chat-->
            <div class="chat-container">
                <!-- Parte de Cima com o nome do chat -->
                <div class="chat-header">
                    <span>Chat com o Suporte</span>
                </div>
                <!--mostrador de mensagens do chat-->
                <div class="messages-container" id="messages-container"></div>
                <!-- formulário onde você preenche o texto que vai enviar no chat-->
                <form id="chat-form" class="chat-form">
                    <input type="hidden" id="usuario" value="<?php echo $id_user; ?>">
                    <input type="hidden" id="nome" value="<?php echo $nome_usuario; ?>">
                    <input type="text" id="mensagem" placeholder="Digite sua mensagem">
                    <input type="hidden" id="tipo" value="cliente">
                    <button class="botaosuporte" type="submit">Enviar</button>
                </form>
            </div>
        </div>
         <!--rodapé-->
        <?php 
            require "rodape.php"; 
        ?>
        <!--Javascript-->
        <script src="js/menu.js"></script>
        <script src="js/darkmode.js"></script>
        <script src="js/suporte.js"></script>
    </body>
</html>