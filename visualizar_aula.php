<?php

    // Incluir a conexao com o BD
    include_once "php/conexao.php";
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

    // Receber o ID do curso
    //$curso_id = filter_input(INPUT_GET, 'id_curso', FILTER_SANITIZE_NUMBER_INT);

    $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
    $resultado_usuario = mysqli_query($conn, $result_usuario);
    while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
        $row_usuario['ID_usuario']."<br>";		
        $row_usuario['Senha']."<br>";

        $usuario = $row_usuario['ID_usuario'];
        $dep = $row_usuario['Dep'];
        $nome_usuario = $row_usuario['Nome'];
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>Site de Treinamento - Detalhes do Curso</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <title>Site de Treinamento - Aula</title>

        <!--coloca o icone na aba da tela-->
        <link rel="icon" type="png" href="../COMUM/img/Icons/Vermelho/copi.png">
        <!--CSS -->
       <!--<link rel="stylesheet" type="text/css" href="css/style.css">-->
       <link rel="stylesheet" type="text/css" href="css/titulo.css">
        <link rel="stylesheet" href="css/menumob.css"><!--novo botão menu lateral-->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/visualizar_aula.css" rel="stylesheet">

    </head>

    <body>
        <?php require "titulo.php"; ?>
            <?php }?> <br><br><br>
            <div class="container my-5">
                <div class="p-5 text-center bg-body-tertiary rounded-3">

                    <?php
                        $query_aula = "SELECT aul.titulo, aul.conteudo, aul.pdf, aul.resumo, aul.modulo_id,
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
                            echo "<p class='descricaotext'><h1 class='text-body-emphasis'>Título da aula: $titulo </h1></p><br>";
                            $moduloid = $modulo_id;
                            echo "<h3> Conteúdo da aula: $conteudo <br>";
                            echo "</h3>";
                    ?>
                    <hr>
                    <div class="container theme-showcase" role="main">
                        <div>
                            <div class="container my-5">
                                    <!-- Nav tabs -->
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#resumo" role="tab" aria-controls="home" aria-selected="true">Resumo da Aula</a>
                                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#pdf" role="tab" aria-controls="dados_de_acesso" aria-selected="false">Pdf da Aula</a>
                                            <a class="nav-item nav-link" id="nav-feed-back" data-toggle="tab" href="#feedback" role="tab" aria-controls="feedback_aula" aria-selected="false">FeedBack</a>
                                            <a class="nav-item nav-link" id="nav-comentario" data-toggle="tab" href="#comentario" role="tab" aria-controls="comentario_aula" aria-selected="false">Comentários</a>
                                            <a class="nav-item nav-link" id="nav-finalizar" data-toggle="tab" href="#finalizar" role="tab" aria-controls="finalizar_aula" aria-selected="false">Finalizar</a>
                                        </div>
                                    </nav>
                                <div class="position-relative p-2 text-justify text-muted bg-body border rounded-5">
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="resumo" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <div style="padding-top:20px;">
                                                <form class="form-horizontal" action="" method="POST">
                                                    <div class="form-group">
                                                        <h1 class="text-body-emphasis">&nbsp;Resumo</h1><br>
                                                        <div class="col-sm-12">
                                                            <?php
                                                                if($resumo != ''){
                                                                echo "$resumo";
                                                                }else{
                                                                    echo "Não há resumo cadastrado nesta aula";
                                                                };
                                                            ?>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="finalizar" role="tabpanel" aria-labelledby="nav-finalizar">
                                            <div style="padding-top:20px;">
                                                <form class="form-horizontal" action="php/atualizar_progresso.php" method="POST">
                                                    <div class="form-group">
                                                        <h1 class="text-body-emphasis">&nbsp;Finalizar aula</h1><br>
                                                        <div class="col-sm-12">
                                                            <!-- Adicione este trecho dentro do formulário de feedback -->
                                                            <button class="btn btn-primary btn-concluir" type="submit">
                                                                Concluir Aula
                                                            </button>
                                                        </div>
                                                    </div>
                                                     <!-- Adicione campos ocultos para enviar informações necessárias ao script PHP -->
                                                    <input type="hidden" name="id_user" value="<?php echo $usuario; ?>">
                                                    <input type="hidden" name="id_curso" value="<?php echo $curso_id; ?>">
                                                    <input type="hidden" name="modulo_id" value="<?php echo $modulo_id; ?>">
                                                    <input type="hidden" name="id_aula" value="<?php echo $id; ?>">
                                                    <input type="hidden" name="porcentagem" value="<?php echo $porcentagem; ?>">
                                                </form>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="feedback" role="tabpanel" aria-labelledby="nav-feed-back">
                                            <div style="padding-top:20px;">
                                                <form class="form-horizontal" action="php/processa.php?aula_id=<?php echo $id?>&modulo_id=<?php echo $moduloid?>&curso_id=<?php echo $curso_id?>" method="POST">
                                                    <div class="form-group">
                                                        <h1 class="text-body-emphasis">&nbsp;Avalie a Aula</h1><br>
                                                        <div class="col-sm-12">
                                                            <?php 
                                                                //imprimir a mensagem de erro ou sucesso salvo na sessão
                                                                if(isset($_SESSION['msg'])){
                                                                    echo $_SESSION['msg'];
                                                                    unset($_SESSION['msg']);
                                                                }
                                                            ?>
                                                            <!-- Inicio do formulário -->
                                                            <form method="POST" action="php/processa.php?aula_id=<?php echo $id?>&modulo_id=<?php echo $moduloid?>&curso_id=<?php echo $curso_id?>">
                                                                <div class="estrelas">

                                                                    <!-- Carrega o formulário definindo nenhuma estrela selecionada -->
                                                                    <input type="radio" name="estrela" id="vazio" value="" checked>

                                                                    <!-- Opção para selecionar 1 estrela -->
                                                                    <label for="estrela_um"><i class="opcao fa"></i></label>
                                                                    <input type="radio" name="estrela" id="estrela_um" id="vazio" value="1">

                                                                    <!-- Opção para selecionar 2 estrela -->
                                                                    <label for="estrela_dois"><i class="opcao fa"></i></label>
                                                                    <input type="radio" name="estrela" id="estrela_dois" id="vazio" value="2">

                                                                    <!-- Opção para selecionar 3 estrela -->
                                                                    <label for="estrela_tres"><i class="opcao fa"></i></label>
                                                                    <input type="radio" name="estrela" id="estrela_tres" id="vazio" value="3">

                                                                    <!-- Opção para selecionar 4 estrela -->
                                                                    <label for="estrela_quatro"><i class="opcao fa"></i></label>
                                                                    <input type="radio" name="estrela" id="estrela_quatro" id="vazio" value="4">

                                                                    <!-- Opção para selecionar 5 estrela -->
                                                                    <label for="estrela_cinco"><i class="opcao fa"></i></label>
                                                                    <input type="radio" name="estrela" id="estrela_cinco" id="vazio" value="5"><br><br>

                                                                    <!-- Campo para enviar a mensagem -->
                                                                    <textarea name="mensagem" rows="4" cols="109" placeholder="Digite o seu comentário..."></textarea><br><br>

                                                                    <!-- Botão para enviar os dados do formulário -->
                                                                    <!--<input type="submit" value="Cadastrar"><br><br>-->

                                                                    <button type="submit" class='btn btn-outline-primary'>Cadastrar</button><br><br>

                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="comentario" role="tabpanel" aria-labelledby="nav-comentario">
                                            <div class="text-center" style="padding-top: 20px;">
                                                <div class="form-group">
                                                    <h1 class="text-body-emphasis">&nbsp;Comentários</h1><br>
                                                    <div class="col-sm-10 offset-sm-1"> <!-- Adicionado a classe mx-auto -->
                                                        <?php
                                                            // Informações do curso, módulo e aula
                                                            $id_curso = $curso_id;  // substitua pelo ID do curso atual
                                                            $id_modulo = $moduloid; // substitua pelo ID do módulo atual (já obtido no código anterior)
                                                            $id_aula = $id;   // substitua pelo ID da aula atual

                                                            // Recuperar as avaliações do banco de dados
                                                            $query_avaliacoes = "SELECT id, qtd_estrela, mensagem, aula_id, curso_id, modulo_id
                                                                                FROM avaliacoes WHERE modulo_id = :id_modulo AND curso_id = :id_curso AND aula_id = :id_aula
                                                                                ORDER BY id DESC";
                                                            $result_avaliacoes = $con->prepare($query_avaliacoes);
                                                            $result_avaliacoes->bindParam(':id_modulo', $id_modulo, PDO::PARAM_INT);
                                                            $result_avaliacoes->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
                                                            $result_avaliacoes->bindParam(':id_aula', $id_aula, PDO::PARAM_INT);

                                                            // Executar a QUERY
                                                            if ($result_avaliacoes->execute()) {
                                                                // Percorrer a lista de registros recuperada do banco de dados
                                                                while ($row_avaliacao = $result_avaliacoes->fetch(PDO::FETCH_ASSOC)) {
                                                                    // Extrair o array para imprimir pelo nome do elemento do array
                                                                    extract($row_avaliacao);

                                                                    echo "<p>Avaliação: $id</p>";

                                                                    // Criar o for para percorrer as 5 estrelas
                                                                    for ($i = 1; $i <= 5; $i++) {
                                                                        // Acessa o IF quando a quantidade de estrelas selecionadas é menor a quantidade de estrela percorrida e imprime a estrela preenchida
                                                                        if ($i <= $qtd_estrela) {
                                                                            echo '<i class="estrela-preenchida fa-solid fa-star"></i>';
                                                                        } else {
                                                                            echo '<i class="estrela-vazia fa-solid fa-star"></i>';
                                                                        }
                                                                    }

                                                                    echo "<p>Mensagem: $mensagem</p><hr>";
                                                                }
                                                            } else {
                                                                echo "Erro na execução da query: " . print_r($result_avaliacoes->errorInfo(), true);
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pdf" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <div class="text-center" style="padding-top: 20px;">
                                                <form class="form-horizontal" action="" method="POST">
                                                    <div class="form-group">
                                                        <h1 class="text-body-emphasis">&nbsp;PDF</h1><br>
                                                        <div class="col-sm-10 offset-sm-1"> <!-- Adicionado a classe mx-auto -->
                                                            <?php 
                                                                //$pdo = new PDO('mysql:host=localhost;dbname=devportalcop', 'root', '');

                                                                // Informações do curso, módulo e aula
                                                                $id_curso = $curso_id;  // substitua pelo ID do curso atual
                                                                $id_modulo = $moduloid; // substitua pelo ID do módulo atual (já obtido no código anterior)
                                                                $id_aula = $id;   // substitua pelo ID da aula atual

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
                                                                        echo "<div class='text-center' style='padding-top: 20px;'>";
                                                                        echo "<form class='form-horizontal' action='' method='POST'>";
                                                                        //echo "<div class='form-group'>";
                                                                        //echo "<div class='col-sm-10 offset-sm-1'>";
                                                                        echo "<div class='row'>"; // Abre a div.row

                                                                        // Itera sobre os resultados para exibir cada PDF
                                                                        $pdf_count = 0; // Inicializa o contador de PDFs exibidos
                                                                        foreach ($stmt_pdf as $row_pdf) {
                                                                            $pdf_count++;
                                                                            $nome_pdf = $row_pdf['nome'];
                                                                            echo "<div class='col-md-4' style='margin-bottom: 20px;'>";
                                                                            echo "<img src='admin/pdf/arquivo.png' width='150'><br><br>$nome_pdf<br><br>";
                                                                            echo "<a href='admin/pdf/32/$nome_pdf' class='btn btn-outline-primary' download>Download</a></button>";
                                                                            echo "</div>";

                                                                            // Fecha a linha da div após exibir três PDFs
                                                                            if ($pdf_count % 3 == 0) {
                                                                                echo "<br>";
                                                                                echo "</div><div class='row'>"; // Fecha e abre uma nova linha
                                                                            }
                                                                        }
                                                                                                                                    
                                                                        echo "</div>";
                                                                        echo "</div>";
                                                                        echo "</form>";
                                                                        echo "</div>";
                                                                    } else {
                                                                        echo "Não há pdf cadastrado nesta aula";
                                                                    }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="messages">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="checkbox" id="check">
                    <label for="check">
                        <div class="menu" >
                            <span class="hamburguer"></span>
                        </div>
                    </label>
                    <div class="barra">
                    <br><br><br><br><br><br><br>
                                <center><br>
                                    <h2>Módulos e Aulas</h2>
                                    
                                    <div class="d-flex justify-content-between align-items-center"><br><br><br>
                                        <div class="btn-group">
                                            <span class="ml-2">Progresso:</span>
                                        </div>
                                        <div class="progress" style="width: <?php echo "$porcentagem"; ?>%; margin: 0 10px;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: <?php echo "$porcentagem"/100; ?>%" aria-valuenow="<?php echo $porcentagem; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="mr-4"><?php echo "$porcentagem"/100;?>%</span>
                                    </div>
                                    <ul class="list-unstyled">
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
                                                                    <img class='seta' src='../COMUM/img/treinamento/seta.png' width='30' height='30'>
                                                                    <div class='num-aulas'>Aulas: ";
                                                                // Exibe o número total de aulas no módulo atual
                                                                echo isset($count_aulas_por_modulo[$id_mdu]) ? $count_aulas_por_modulo[$id_mdu] : 0;

                                                            echo "      </div>
                                                                    </div>
                                                                </div>";
                                                        echo "<div class='aulas' style='display: none'>";
                                                    }

                                                    // Verifica se a aula está cadastrada na tabela progresso_aula
                                                    $query_progresso = "SELECT * FROM progresso_aula WHERE id_usuario = $usuario AND id_aula = $id_aul";
                                                    $resultado_progresso = mysqli_query($conn, $query_progresso);

                                                    if ($resultado_progresso) {
                                                        $registro_progresso = mysqli_fetch_assoc($resultado_progresso);
                        
                                                        if ($registro_progresso) {
                                                            // Se houver um registro, a aula já foi iniciada
                                                            if ($registro_progresso['concluida']) {
                                                                // Se a aula foi concluída, exibir o botão "Finalizado"
                                                                echo "<div class='aula'>
                                                                        <div class='aula-inner'>
                                                                            <p class='aula-titulo'>Aulas: $ordem | Título: $titulo | <a class='btn btn-success' href='visualizar_aula.php?id_usuario=$id_user&id=$id_aul&modulo_id=$id_mdu&curso_id=$id_curso&porcentagem=$porcentagem'>Concluído</a></p>
                                                                        </div>
                                                                    </div>";
                                                            } else {
                                                                // Se a aula está em andamento, exibir o botão "Continuar"
                                                                echo "<div class='aula'>
                                                                        <div class='aula-inner'>
                                                                            <p class='aula-titulo'>Aulas: $ordem | Título: $titulo | <a class='btn btn-primary' href='visualizar_aula.php?id_usuario=$id_user&id=$id_aul&modulo_id=$id_mdu&curso_id=$id_curso&porcentagem=$porcentagem'>Continuar</a></p>
                                                                        </div>
                                                                    </div>";
                                                            }
                                                        } else {
                                                            // Se não houver registro, a aula ainda não foi iniciada
                                                            // Exibir o botão "Começar"
                                                            echo "<div class='aula'>
                                                                    <div class='aula-inner'>
                                                                        <p class='aula-titulo'>Aulas: $ordem | Título: $titulo | <a class='btn btn-danger' href='php/iniciar_aula.php?id_usuario=$usuario&id_aula=$id_aul&modulo_id=$id_mdu&curso_id=$id_curso&porcentagem=$porcentagem'>Começar</a></p>
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
                                        } else {
                                            echo "<p style='color: #f00;'>Erro: Aula não encontrada!</p>";
                                        }
                                        ?>
                                    </ul>
                                <!--</font>-->
                            </div>
                        </p>
                    <!--</div>-->
                    </div>
                </div>
            </div>

        <!--inicio Botão de voltar ao topo-->
        <button id="myBtn" title="Go to top">Subir</button>
        <script>window.jQuery || document.write('<script src="javascript/jquery.slim.min.js"><\/script>')</script><script src="javascript/bootstrap.bundle.min.js"></script>  
        <script src="javascript/menu.js" defer></script>
        <script src="javascript/subir.js"></script>
        <script src="javascript/darkmode.js"></script>
    </body>
</html>