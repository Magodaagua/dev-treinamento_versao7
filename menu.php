<!doctype html>
<html lang="pt-br">
  <!--coloca o icone na aba da tela-->
  <link rel="icon" type="png" href="../COMUM/img/Icons/Vermelho/copi.png">
  <!-- Conexão com o banco de dados -->
  <?php
    include_once("php/conexao.php");

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
    <title>Site de Treinamento - Menu</title>

    <!--CSS -->
    <link rel="stylesheet" type="text/css" href="css/titulo.css">
    <link href="https://fonts.cdnfonts.com/css/community" rel="stylesheet">

    <style>
        .dark-mode {
          background-color: #222;
          color: #fff;
        }
    </style>
  </head>
  <body>
    <?php require "titulo.php"; ?>
      <?php ?> 
      <main>
        <div class="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="../COMUM/img/cursos/Capa1.png<?php //echo $row_menu['carrosel1'];?>">
            </div>
            <div class="carousel-item">
              <img src="../COMUM/img/cursos/capa2.png<?php //echo $row_menu['carrosel2'];?>">
            </div>
            <!--<div class="carousel-item">
              <img src="../COMUM/img/cursos/capaCursos3.png<?php //echo $row_menu['carrosel3'];?>">
            </div>-->
          </div>
          <div class="carousel-nav">
           <div class="arrow-container">
              <div class="carousel-prev">&lt;</div>
              <div class="carousel-next">&gt;</div>
            </div>
          </div>
          <div class="carousel-indicators"></div>
        </div>
          <?php 
            $query_continuar = "SELECT c.ID_curso, c.Nome, c.Autor, c.Categoria, c.Subcategoria, c.Descricao, c.Datadecriacao, c.Carga_horaria, c.inscritos, c.imagem, i.progresso
                                FROM curso c
                                INNER JOIN inscricao i ON c.ID_curso = i.id_curso
                                WHERE i.id_usuario = '$id_user'";
            $result_continuar = mysqli_query($conn, $query_continuar);

            // Inicializa a variável que indica se algum curso tem progresso diferente de 100%
            $algum_curso_com_progresso_nao_completo = false;
            $cursos_a_exibir = []; // Array para armazenar os cursos que precisam ser exibidos

            // Verifica se a consulta foi bem-sucedida
            if ($result_continuar) {
                // Loop para percorrer os resultados
                while ($row = mysqli_fetch_assoc($result_continuar)) {
                    // Verifica se o progresso do curso é diferente de 100
                    if ($row['progresso'] != 100) {
                        // Se pelo menos um curso tiver progresso diferente de 100, define a flag como true e adiciona o curso ao array
                        $algum_curso_com_progresso_nao_completo = true;
                        $cursos_a_exibir[] = $row; // Adiciona o curso ao array
                    }
                }

                // Se algum curso tiver progresso diferente de 100%, exibe o conteúdo
                if ($algum_curso_com_progresso_nao_completo) {
            ?>
            <div class="containerContinueAprendendo">
                <h1> | Continue aprendendo </h1>
            </div>
            <div class="custom-carousel">
                <div class='container-seta'>
                    <div class='control-preve'>&lt;</div>
                </div>
                <?php
                // Exibe os cursos que precisam ser exibidos
                foreach ($cursos_a_exibir as $curso) {
                ?>
                <div class='custom-car'>
                    <div class='curso-andamento'>
                        <div class='divImgContinuar'>
                            <img src='../COMUM/img/cursos/capa_dos_cursos/<?php echo $curso['imagem']; ?>' alt='Imagem 1'>
                        </div>
                        <div class='textos'>
                            <h4><?php echo $curso['Nome']; ?></h4>
                            <p>Nome do(a) instrutor(a): <?php echo $curso['Autor']; ?></p>
                            <div class='btnContinuarCurso'>
                                <a href='detalhes.php?ID_curso=<?php echo $curso['ID_curso']; ?>&progresso=0'><button type='button' class='continua'>Continuar</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
                <div class='container-seta'>
                    <div class='control-nexte'>&gt;</div>
                </div>
                <div class="carousel-indicators"></div>
            </div>
            </div>
            <?php
                } else {
                    // Se todos os cursos tiverem progresso igual a 100%, você pode exibir uma mensagem indicando que todos foram concluídos
                    echo "<p>Todos os cursos foram concluídos com sucesso.</p>";
                }
            } else {
                echo "Erro na execução da consulta: " . mysqli_error($conn);
            }
            ?>

            <!--<div class="container-seta"><div class="control-nexte">&gt;</div></div>-->
            <div class="carousel-indicators"></div>
          </div>
        </div>
          <!-- sugestao de curso -->
          <div class="SugestaoCurso">
            <!--<hr style="height:1px;border-width:0;color:black;background-color:black">-->
            <div class="containerContinueAprendendo">
              <?php
                  $query_inscricao = "SELECT COUNT(*) AS total_inscricoes FROM inscricao WHERE id_usuario = '$id_user'";
                  $result_inscricao = mysqli_query($conn, $query_inscricao);

                  $total_inscricoes = 0;
                  if ($result_inscricao && mysqli_num_rows($result_inscricao) > 0) {
                      $row_inscricao = mysqli_fetch_assoc($result_inscricao);
                      $total_inscricoes = $row_inscricao['total_inscricoes'];
                  }

                  if ($total_inscricoes > 0) {
                      // O usuário está inscrito em pelo menos um curso
                      echo'<h1>| O que você pode aprender em seguida?</h1> <p>Recomendados para você:</p><br>';
                  } else {
                      // O usuário não está inscrito em nenhum curso
                      echo'<h1>| Cursos em destaque</h1>';
                  }
              ?>

            </div>
            <div class="slider">
              <div class="container-seta-2">
                <div class="control-preve-dois">&lt;</div>
              </div>
                <?php
                $query_nao_inscrito = " SELECT c.ID_curso, c.Autor, c.Nome, c.Categoria, c.Subcategoria, c.Descricao, c.Datadecriacao, c.Carga_horaria, c.inscritos, c.imagem, cat.Nome_cat AS NomeCategoria
                                        FROM curso c
                                        LEFT JOIN inscricao i ON c.ID_curso = i.id_curso AND i.id_usuario = '$id_user'
                                        LEFT JOIN categoria cat ON c.categoria = cat.id
                                        WHERE i.id_curso IS NULL";
                $result_nao_inscrito = mysqli_query($conn, $query_nao_inscrito);
                // Verifica se a consulta foi bem-sucedida
                if ($result_nao_inscrito) {
                    // Inicializa o contador de cursos
                    $contadorCursos = 0;
                    // Loop para percorrer os resultados
                    while ($row2 = mysqli_fetch_assoc($result_nao_inscrito)) {
                        // Verifica se o progresso não é 100, se for, não exibe no carrossel
                        if ($dep == $row2["NomeCategoria"]) {
                            // Verifica se ainda não atingiu o número máximo de cursos
                            //if ($contadorCursos < 5) {
                                echo "<div class='carrossel-tres'>
                                        <div class='cursos-do-carrossel'>
                                            <div class='Imagem-carrossel-dois'>
                                              <img src='../COMUM/img/cursos/capa_dos_cursos/" . $row2['imagem'] . "' alt='Imagem 1'>
                                            </div>
                                            <div class='carrosel-textos-dois'><br>
                                                <h4>" . $row2['Nome'] . "</h4>
                                                <p> Nome do(a) instrutor(a):<br> " . $row2['Autor'] . "</p><br>
                                                <div class='btnContinuarCurso-botao'>
                                                    <a href='detalhes.php?ID_curso={$row2['ID_curso']}&progresso=0'><button type='button' class='continua-botao'>Começar</button></a>
                                                </div>
                                            </div>
                                        </div>
                                      </div>";
                                // Incrementa o contador de cursos exibidos
                                $contadorCursos++;
                            //}
                        }
                    }
                    // Fecha a conexão do carrossel
                    echo "<div class='container-seta-2'>
                            <div class='control-nexte-dois'>&gt;</div>
                          </div>";
                    echo "</div>";
                } else {
                    echo "Erro na execução da consulta: " . mysqli_error($conn);
                }
                ?>
            </div><br>
        <!-- fim sugestao de curso -->
        <!--inicio Botão de voltar ao topo-->
        <button id="myBtn" title="Go to top">Subir</button>
      </main>
    <script src="javascript/carrossels.js"></script>
    <script src="javascript/carrosselc.js"></script>
    <script src="javascript/carrosselb.js"></script>
    <script src="javascript/subir.js"></script>
    <script src="javascript/darkmode.js"></script>
  </body>
</html>
