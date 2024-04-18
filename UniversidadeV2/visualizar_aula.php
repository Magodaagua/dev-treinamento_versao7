<!DOCTYPE html>
<html lang="pt-br">
    <?php
        // conexão com banco de dados
        include_once("php/conexao.php");

        // conexão com o banco de dados via new pdo
        $pdo = new PDO('mysql:host=192.168.1.10;dbname=DevPortalCop', 'DevUser2', 'BV!A2k1$e61ms#yeQpE4j');

        // Receber o ID do usuário
        $id_user = filter_input(INPUT_GET, 'id_user', FILTER_SANITIZE_NUMBER_INT);
        // Receber o ID da aula
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        // Receber o porcentagem da aula
        $porcentagem = filter_input(INPUT_GET, 'porcentagem', FILTER_SANITIZE_NUMBER_FLOAT);
        // Receber o ID da modulo
        $modulo_id= filter_input(INPUT_GET, 'modulo_id', FILTER_SANITIZE_NUMBER_INT);
        // Receber o ID do curso
        $curso_id= filter_input(INPUT_GET, 'curso_id', FILTER_SANITIZE_NUMBER_INT);

        // pega todas as informações do usuário e salva em variáveis 
        $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
        $resultado_usuario = mysqli_query($conn, $result_usuario);

        if ($row_usuario = mysqli_fetch_assoc($resultado_usuario)) {
            $id_user = $row_usuario['ID_usuario'];
            $dep = $row_usuario['Dep'];
            $nome_usuario = $row_usuario['Nome'];
            $abreviacao = $row_usuario['Abreviacao'];
        }

        // pega todas as informações do curso que teve o id passado pela URL
        $result_curso = "SELECT * FROM curso WHERE ID_curso = '$curso_id'";
        $resultado_curso = mysqli_query($conn, $result_curso);
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Titulo -->
        <title>Visualizar Aula 2</title>
        <!--coloca o icone na aba da tela-->
        <link rel="icon" type="png" href="../../COMUM/img/Icons/Vermelho/imgML13.png">
        <!--CSS-->
        <link href="https://fonts.cdnfonts.com/css/community" rel="stylesheet">
        <link rel="stylesheet" href="css/tudo.css">
    </head>
    <body>
        <?php 
            // menu superior
            require "titulo.php"; 

            //busca no banco de dados 
            $query_aula = " SELECT aul.titulo, aul.conteudo, aul.pdf, aul.resumo, aul.modulo_id,
                                    mdu.curso_id
                            FROM aulas aul
                            INNER JOIN modulos AS mdu ON mdu.id=aul.modulo_id
                            WHERE aul.id=:id
                            /*WHERE aul.id=:id AND aul.modulo_id =:modulo_id AND mdu.curso_id =:curso_id*/
                            LIMIT 1";
            $result_aula = $pdo->prepare($query_aula);
            $result_aula->bindParam(':id', $id);
            //$result_aula->bindParam(':aul.modulo_id', $modulo_id);
            //$result_aula->bindParam(':mdu.curso_id', $curso_id);
            $result_aula->execute();

            // Acessa o IF quando encontrar a aula no BD
            if (($result_aula) and ($result_aula->rowCount() != 0)) {
                $row_aula = $result_aula->fetch(PDO::FETCH_ASSOC);
                //var_dump($row_aula);
                extract($row_aula);
        ?>
        <!-- página toda -->
        <div class="quadradograndeaulas">
            <!-- campo da direita onde fica o video -->
            <div class="videoaulas">
                <?php 
                    //video salvo no banco de dados
                    echo $conteudo;
                ?>
            </div>
            <!-- retangulo lateral onde fica as opções e informações -->
            <div class="retangulolateralesquerdacomaulas">
                <!-- opções do topo -->
                <div class="retangulolateralesquerdacomaulastitulos">
                    <!-- botão aulas -->
                    <div class="botaoaulas" id="openMenu">
                        <img src="../../COMUM/img/cursos/imagens/menu.png">&nbsp;
                        Aulas
                    </div>
                    <!-- anotações -->
                    <div class="botaoanotacoesverde">
                        <img src="../../COMUM/img/cursos/imagens/bloco-de-anotacoes.png">
                    </div>
                    <!-- favoritar -->
                    <div class="botaofavoritar">
                        <img src="../../COMUM/img/cursos/imagens/gostar.png">
                    </div>
                    <!-- calendario  -->
                    <div class="botaocalendario">
                        <img src="../../COMUM/img/cursos/imagens/calendario.png">
                    </div>
                    <!-- trás -->
                    <div class="botaotras">
                        <img src="../../COMUM/img/cursos/imagens/seta.png">
                    </div>
                    <!-- frente -->
                    <div class="botaofrente">
                        <img src="../../COMUM/img/cursos/imagens/seta.png">
                    </div>
                </div>
                <!-- titulo da aula, descricão, pdf, feedback e finalizar --> 
                <div class="retangulolateralesquerdacomaulasdescricao">
                    <!-- titulo da aula -->
                    <div class="retangulolateraltitulo">
                        <?php echo $titulo; ?>
                    </div>
                    <!-- menu inferior para ficar trocando informação -->
                    <div class="retangulolateralopcoes">
                        <!-- menu inferior -->
                        <div class="tabs">
                            <button class="tab-button active" data-tab="home">Descrição</button>
                            <button class="tab-button" data-tab="profile">PDFs</button>
                            <button class="tab-button" data-tab="contact">Feedback</button>
                            <button class="tab-button" data-tab="finalizarbotao">Finaliza</button>
                            <div class="tab-indicator"></div> <!-- Linha dourada -->
                        </div>

                        <!-- parte do menu responsavel pelo botão de finalizar -->
                        <div class="tab-content" id="tab-content">
                            <div class="tab-pane" id="finalizarbotao-content">
                                <form class="form-horizontal" action="php/atualizar_progresso.php" method="POST">
                                    <button class="botaofinalizacao" type="submit">
                                        Concluir Aula
                                    </button>
                                    <!-- Adicione campos ocultos para enviar informações necessárias ao script PHP -->
                                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                                    <input type="hidden" name="id_curso" value="<?php echo $curso_id; ?>">
                                    <input type="hidden" name="modulo_id" value="<?php echo $modulo_id; ?>">
                                    <input type="hidden" name="id_aula" value="<?php echo $id; ?>">
                                    <input type="hidden" name="porcentagem" value="<?php echo $porcentagem; ?>">
                                </form>
                            </div>
                            <!-- descrição do curso -->
                            <div class="tab-pane active" id="home-content">
                                <?php
                                    if($resumo != ''){
                                        echo $resumo; 
                                    }else{
                                        echo "Ainda não foi regitrado nenhuma descrição para esse curso";
                                    }
                                ?>
                            </div>
                            <!-- PDF's -->
                            <div class="tab-pane" id="profile-content">
                                <?php 
                                    //$pdo = new PDO('mysql:host=localhost;dbname=devportalcop', 'root', '');

                                    // Informações do curso, módulo e aula
                                    $id_curso = $curso_id;  // substitua pelo ID do curso atual
                                    $id_modulo = $modulo_id; // substitua pelo ID do módulo atual (já obtido no código anterior)
                                    $id_aula = $id;   // substitua pelo ID da aula atual

                                    /*echo "curso id: ". $id_curso. "<br> modulo id: " . $id_modulo ."<br>aula id: ". $id_aula. "<br>";*/

                                    // Consulta para obter o nome do PDF associado à aula atual
                                    $query_pdf = "SELECT pdf_aula.nome FROM pdf_aula
                                                WHERE pdf_aula.curso_id = :curso_id
                                                AND pdf_aula.modulo_id = :modulo_id
                                                AND pdf_aula.aula_id = :aula_id";

                                    $stmt_pdf = $pdo->prepare($query_pdf);
                                    $stmt_pdf->bindParam(':curso_id', $id_curso);
                                    $stmt_pdf->bindParam(':modulo_id', $id_modulo);
                                    $stmt_pdf->bindParam(':aula_id', $id_aula);
                                    $stmt_pdf->execute();

                                    // Adicione var_dump para depuração
                                    //var_dump($id_curso, $id_modulo, $id_aula);

                                    if ($stmt_pdf->rowCount() > 0) {
                                        echo "<div class='pdfbox'>";
                                        echo "<div class='listadepdfs'>"; // Abre a div.listadepdfs
                                
                                        $pdf_count = 0; // Inicializa o contador de PDFs exibidos
                                        foreach ($stmt_pdf as $row_pdf) {
                                            $pdf_count++;
                                            $nome_pdf = $row_pdf['nome'];
                                
                                            // Abre uma nova linha a cada dois PDFs
                                            if ($pdf_count % 2 == 1) {
                                                echo "<div class='pdf-row'>";
                                            }
                                
                                            echo "<div class='pdfinformacao'>";
                                            echo "<img src='../PDF/arquivo.png'>$nome_pdf<br><br>";
                                            echo "<a href='../PDF/$nome_pdf' download>Download</a>";
                                            echo "</div>";
                                
                                            // Fecha a linha da div após exibir dois PDFs
                                            if ($pdf_count % 2 == 0) {
                                                echo "</div>"; // Fecha a div.pdf-row
                                            }
                                        }
                                
                                        // Fecha a linha final caso o último grupo de PDFs não tenha completado uma linha completa
                                        if ($pdf_count % 2 != 0) {
                                            echo "</div>"; // Fecha a div.pdf-row
                                        }
                                
                                        echo "</div>"; // Fecha a div.listadepdfs
                                        echo "</div>"; // Fecha a div.pdfbox
                                    } else {
                                        echo "Não há PDF cadastrado nesta aula";
                                    }
                                ?>
                            </div>
                            <!-- parte dos comentários dos usuários  -->
                            <div class="tab-pane" id="contact-content">
                                Em desenvolvimento
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            }
        ?>
        <?php 
            while($row_cursos = mysqli_fetch_assoc($resultado_curso)){   
        ?>
        <!-- Menu lateral -->
        <div id="sideMenu">
            <!-- botão de fechar -->
            <button id="closeMenu">X</button>
            <!-- parte de cima com imagem, titulo, descrição, etc. -->
            <div class="menulateralquadrado">
                <!-- imagem -->
                <div class="menulateralquadradoimagem">
                    <img src="../../COMUM/img/cursos/capa_dos_cursos/<?php echo $row_cursos['imagem'] ?>">
                </div>
                <!-- Nome do curso -->
                <div class="menulateralquadradotexto">
                    <div class="menulateralquadradotextotitulo">
                        <?php echo $row_cursos['Nome']; ?>
                    </div>
                    <!-- linha embaixo do nome -->
                    <hr class="linha">
                    <!-- descrição -->
                    <div class="menulateralquadradotextodescricao">
                        <?php echo substr($row_cursos['Descricao'], 0, 200) . '...';?>
                    </div>
                    <!-- parte pequena onde tem a carga horária e o botão ver aulas  -->
                    <div class="menulateralquadradotextoopcoes">
                        <!-- Carga horária -->
                        <div class="menulateralquadradotextoopcoesquantidadem">
                            Carga horária: <?php echo $row_cursos['Carga_horaria']; ?> horas
                        </div>
                        <!-- Ver aulas -->
                        <div class="menulateralquadradotextoopcoesveraulas">
                            <img src="../../COMUM/img/Icons/Preto/play-button2.png">&nbsp; 
                            Ver Aulas
                        </div>
                    </div>
                </div>
            </div>
            <!-- espaço onde fica a pesquisa-->
            <div class="menulateralpesquisa">
                <!-- campo de pesquisa -->
                <div class="barradebuscadetalhes">
                        <input type="text" name="pesquisadetalhes" class="pesquisadetalhes" id="pesquisadetalhes" placeholder="Digitar...">
                    </div>
                    <!-- botão da pesquisa-->
                    <div class="botaobuscadetalhes">
                        <button type="submit" class="lupadetalhes" onclick="return preencherCategoria()">
                            <img src="../../COMUM/img/cursos/imagens/loupe.png">
                        </button>
                    </div>
                </div>
            <!-- aqui é onde ficam os módulos -->
            <div class="menulateralaulas">
                <div class="modulodetalhes" id="modulodetalhes">
                    <?php
                        // Recupere as aulas e módulos do curso no BD
                        $query_aulas = "SELECT aul.id id_aul, aul.titulo, aul.ordem,
                        mdu.id id_mdu, mdu.nome nome_mdu
                        FROM aulas aul 
                        INNER JOIN modulos AS mdu ON mdu.id = aul.modulo_id 
                        WHERE mdu.curso_id=:curso_id 
                        ORDER BY mdu.ordem, aul.ordem ASC";
                        $result_aulas = $con->prepare($query_aulas);
                        $result_aulas->bindParam(':curso_id', $curso_id);
                        $result_aulas->execute();

                        // Consulta para contar o número total de aulas por módulo
                        $query_count_aulas = "SELECT modulo_id, COUNT(*) as total_aulas FROM aulas WHERE modulo_id IN (SELECT id FROM modulos WHERE curso_id=:curso_id) GROUP BY modulo_id";
                        $stmt_count_aulas = $con->prepare($query_count_aulas);
                        $stmt_count_aulas->bindParam(':curso_id', $curso_id);
                        $stmt_count_aulas->execute();
                        $count_aulas_por_modulo = array();

                        // Use um loop para exibir os módulos e aulas
                        if (($result_aulas) and ($result_aulas->rowCount() != 0)) {
                            $modulo_anterior = null;
                            $num_aulas_modulo = 0; // Contador de aulas para o módulo atual

                            while ($row_count_aulas = $stmt_count_aulas->fetch(PDO::FETCH_ASSOC)) {
                                $count_aulas_por_modulo[$row_count_aulas['modulo_id']] = $row_count_aulas['total_aulas'];
                            }
                            
                            $modulo_anterior = null;

                            while ($row_aula = $result_aulas->fetch(PDO::FETCH_ASSOC)) {
                                extract($row_aula);

                                if ($modulo_anterior !== $id_mdu) {
                                    if (!is_null($modulo_anterior)) {                         
                                        echo "</div>";
                                    }

                                    echo "<div class='modulo'>
                                            <h5>Nome do módulo: $nome_mdu</h5>
                                            <div class='fundo-transparente'>
                                                <img class='seta' src='../../COMUM/img/treinamento/seta.png' width='30' height='30'>
                                                <div class='num-aulas'>Aulas: ";
                                            // Exibe o número total de aulas no módulo atual
                                            echo isset($count_aulas_por_modulo[$id_mdu]) ? $count_aulas_por_modulo[$id_mdu] : 0;

                                        echo "      </div>
                                                </div>
                                            </div>";
                                    echo "<div class='aulas' style='display: none'>";
                                }

                                // Verifica se a aula está cadastrada na tabela progresso_aula
                                $query_progresso = "SELECT * FROM progresso_aula WHERE id_usuario = $id_user AND id_aula = $id_aul";
                                $resultado_progresso = mysqli_query($conn, $query_progresso);

                                if ($resultado_progresso) {
                                    $registro_progresso = mysqli_fetch_assoc($resultado_progresso);

                                    if ($registro_progresso) {
                                        // Se houver um registro, a aula já foi iniciada
                                        if ($registro_progresso['concluida']) {
                                            // Se a aula foi concluída, exibir o botão "Finalizado"
                                            echo "<div class='aula'>
                                                    <div class='aula-inner'>
                                                        <p class='aula-titulo'>Aulas: $ordem | Título: $titulo | <a class='botaodetalhes' href='visualizar_aula.php?id_usuario=$id_user&id=$id_aul&modulo_id=$id_mdu&curso_id=$curso_id'>Concluído</a> | Status: <font color= green> Concluído </font>
                                                    </div>
                                                </div>";
                                        } else {
                                            // Se a aula está em andamento, exibir o botão "Continuar"
                                            echo "<div class='aula'>
                                                    <div class='aula-inner'>
                                                        <p class='aula-titulo'>Aulas: $ordem | Título: $titulo | <a class='botaodetalhes' href='visualizar_aula.php?id_usuario=$id_user&id=$id_aul&modulo_id=$id_mdu&curso_id=$curso_id'>Continuar</a> | Status: <font color=#4169e1> Em andamento </font> </p>
                                                    </div>
                                                </div>";
                                        }
                                    } else {
                                        // Se não houver registro, a aula ainda não foi iniciada
                                        // Exibir o botão "Começar"
                                        echo "<div class='aula'>
                                                <div class='aula-inner'>
                                                    <p class='aula-titulo'>Aulas: $ordem | Título: $titulo | <a class='botaodetalhes' href='php/iniciar_aula.php?id_usuario=$id_user&id_aula=$id_aul&modulo_id=$id_mdu&curso_id=$curso_id'>Começar</a> | Status: <font color= red> Não iniciado </font> 
                                                </div>
                                            </div>";
                                    }
                                } else {
                                    // Trate o erro, se houver algum
                                    echo "Erro na consulta: " . mysqli_error($conn);
                                }

                                $modulo_anterior = $id_mdu;
                            }

                            // Adiciona o texto para o último módulo
                            //echo "<div class='num-aulas'>Aulas: $num_aulas_modulo</div>";
                            // Fecha o último contêiner das aulas
                                if (!is_null($modulo_anterior)) {
                                    echo "</div>";
                                }
                            //echo "</div>"; // Fecha o contêiner do último módulo
                            echo "</div>"; // Fecha o contêiner geral
                        } else {
                            echo "<p style='color: #f00;'>Erro: Nenhuma aula encontrada!</p>";
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php 
            }
            //rodapé
            require "rodape.php"; 
        ?>
        <!-- javascript -->
        <script src="js/darkmode.js"></script>
        <script src="js/zoom.js"></script>
        <script src="js/tablist.js"></script>
        <script src="js/menulateral.js"></script>
        <script src="js/modulos.js"></script>
    </body>
</html>