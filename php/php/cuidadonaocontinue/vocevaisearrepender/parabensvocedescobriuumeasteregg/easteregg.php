<!doctype html>
<html lang="pt-br">
  <!--coloca o icone na aba da tela-->
  <link rel="icon" type="png" href="../../../../../../COMUM/img/Icons/Vermelho/copi.png">
  <!-- Conexão com o banco de dados -->
  <!-- link: http://dev.intranet.copimaq.local/CURSOS/php/nadaparaseveraqui/mentiraexistealgoaqui/continueparadescobrir/eastereggafrente/easteregg.php   -->
  <?php
    include_once("conexao.php");

    $usuario = "guilherme.patez";

    $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
    $resultado_usuario = mysqli_query($conn, $result_usuario);

    if ($row_usuario = mysqli_fetch_assoc($resultado_usuario)) {
        $id_user = $row_usuario['ID_usuario'];
        $dep = $row_usuario['Dep'];
        $nome_usuario = $row_usuario['Nome'];

        // Imprimir o primeiro nome do usuário
        imprimirNomeUsuario($nome_usuario);
    }

    function imprimirNomeUsuario($nome_usuario) {
        // Divide o nome do usuário em palavras separadas por espaço
        $palavras = explode(' ', $nome_usuario);

    }
  ?>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Easter egg</title>
    <!--CSS -->
    <link href="https://fonts.cdnfonts.com/css/community" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <!-- Parte 1: Topo -->
    <header class="topo">
    <div class="imagem-topo">
        <img class="imagemtopo" src="img/giphy.gif" alt="Muito obrigado por usar o meu site">
        <div class="texto-sobre-imagem">
            Muito obrigado por usar o meu site
            <br><br>
            Agora fique com esse pequeno easter egg
        </div>
    </div>
    </header>
    <!-- Parte 2: Créditos -->
    <section class="creditos">
    <h2>Créditos</h2>
      <div class="creditos-container">
        <ul class="creditos-lista">
          <li>Seu Nome</li>
          <li>Nome do colaborador 1</li>
          <li>Nome do colaborador 2</li>
          <!-- Adicione mais nomes conforme necessário -->
        </ul>
      </div>
    </section>
    <!-- Parte 3: Links de Inspiração -->
    <section class="inspiracao">
      <h2>Links de Inspiração</h2>
      <div class="cenário">
        <div class="item-mario moeda">
          <a href="#">Link 1</a>
        </div>
        <div class="item-mario flor">
          <a href="#">Link 2</a>
        </div>
        <div class="item-mario cogumelo">
          <a href="#">Link 3</a>
        </div>
        <div class="item-mario estrela">
          <a href="#">Link 4</a>
        </div>
      </div>
    </section>
    <!-- Parte 4: Algo Legal (a ser definido mais tarde) -->
    <section class="algo legal">


    </section>
    <!-- Elemento de áudio no rodapé -->
    <footer class="footer">
      <!-- Botão de voltar -->
      <button class="botao-voltar" onclick="window.location.href = 'menu.html'">Voltar para o Menu</button>
      <div class="audio-container">
        <img id="vitrola" src="img/gramophone.gif" alt="Vitrola">&nbsp;
        <audio id="audioPlayer" controls autoplay>
          <source src="musica/musica.mp3" type="audio/mp3">
          Seu navegador não suporta o elemento de áudio.
        </audio>
      </div>
    </footer>
    <!--inicio Botão de voltar ao topo-->
    <button id="myBtn" title="Go to top">Subir</button>
    <script src="javascript/subir.js"></script>
    <script src="javascript/darkmode.js"></script>
    <script src="javascript/musica.js"></script>
  </body>
</html>
