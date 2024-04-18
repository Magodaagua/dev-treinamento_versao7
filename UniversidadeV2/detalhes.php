<!DOCTYPE html>
<html lang="pt-br">
        <!-- Conexão com o banco de dados -->
	<?php
        //conexão com o banco de dados
        include_once("php/conexao.php"); 

        //pega os dados passados pela URL
        $ID_curso = isset($_GET['ID_curso']) ? $_GET['ID_curso'] : null;
        $Usuario = isset($_GET['Usuario']) ? $_GET['Usuario'] : null;
        $progresso = isset($_GET['progresso']) ? $_GET['progresso'] : null;

        //coleta todas as informações do usuário
        $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
        $resultado_usuario = mysqli_query($conn, $result_usuario);

        if ($row_usuario = mysqli_fetch_assoc($resultado_usuario)) {
            $id_user = $row_usuario['ID_usuario'];
            $dep = $row_usuario['Dep'];
            $nome_usuario = $row_usuario['Nome'];
            $abreviacao = $row_usuario['Abreviacao'];
        }

        //pega todas as informações do curso
        $result_curso = "SELECT * FROM curso WHERE ID_curso = '$ID_curso'";
        $resultado_curso = mysqli_query($conn, $result_curso);
        // "roda" todas as informações do curso e salva elas em variáveis
        while($row_cursos = mysqli_fetch_assoc($resultado_curso)){

            // Obtém a data do curso e a formata
            //$data_atualizada = $row_cursos["Datadecriacao"];
            //echo $data_atualizada; // Verifique o valor da data
            $data_atualizada = intval($row["Datadecriacao"]);
            date_default_timezone_set('America/Sao_Paulo'); // Defina o fuso horário para São Paulo, por exemplo
          
            //meses de Janeiro até Dezembro
            $meses = array(
                1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
            );
            //transforma a data salva no banco de dados em uma data legivel
            $data_legivel = date('d \d\e ', $data_atualizada) . $meses[date('n', $data_atualizada)] . date(' \d\e Y', $data_atualizada);
            //echo date('d \d\e F \d\e Y', $data_atualizada); // Verifique o valor da data formatada
            //$data_legivel = date('d \d\e F \d\e Y', $data_atualizada);
            //$data_legivel = date('d \d\e F \d\e Y', $data_atualizada); // Formata a data
            //$data_legivel = date('Y-m-d', $data_atualizada); // Formato simples para teste
      
            // Verifica se o progresso é igual a 2 ai salva na tabela inscrição
            if($progresso == 2){
                // Insere os dados da inscrição no banco de dados
                //echo $progresso;
                $result_inscricao2 = "INSERT INTO inscricao (id_curso, id_usuario, progresso, certificado) VALUES ($ID_curso, $id_user, $progresso, 'sim')";
                $resultado_inscricao2 = mysqli_query($conn, $result_inscricao2);
                
                // Verifica se a inserção foi bem-sucedida
                if($resultado_inscricao2) {
                    //echo "Inscrição realizada com sucesso!";
                } else {
                    //echo "Erro ao realizar a inscrição.";
                }
            } else {
                //echo "Progresso inválido.";
            }
        //}

        // Verificar progresso e atualizar a inscrição se for 100%
        if ($progresso == 100) {
            $data_conclusao = date('Y-m-d'); // Data atual
            
            $query_update_inscricao = "UPDATE inscricao 
                                    SET progresso = ?, data_conclusao = ?
                                    WHERE id_usuario = ? AND id_curso = ?";
            $stmt_update_inscricao = $conn->prepare($query_update_inscricao);
            $stmt_update_inscricao->bind_param("issi", $progresso, $data_conclusao, $id_user, $ID_curso);
            $stmt_update_inscricao->execute();

            if ($stmt_update_inscricao->affected_rows > 0) {
                // Atualização bem-sucedida
                //echo "Parabéns! Você concluiu o curso em $data_conclusao";
            } else {
                // Tratar falha na atualização da inscrição
                //echo "Erro ao atualizar a inscrição.";
            }
        }
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detalhes 2</title>
        <!--coloca o icone na aba da tela-->
        <link rel="icon" type="png" href="../../COMUM/img/Icons/Vermelho/imgML13.png">
        <!--CSS-->
        <link rel="stylesheet" href="css/tudo.css">
    </head>
    <body>
        <?php 
            //conexão com o banco de dados
            require "titulo.php"; 

            // Adicione esta linha para garantir que o array esteja inicializado
            $porcentagens_por_modulo = array(); 

            // Consulta SQL para obter a porcentagem de aulas concluídas
            $query_porcentagem = "
            SELECT ((COUNT(pa.id_aula_concluida) / COUNT(DISTINCT a.id)) * 100) AS porcentagem_concluida
            FROM aulas a
            LEFT JOIN modulos m ON a.modulo_id = m.id
            LEFT JOIN (
                SELECT id_aula, 1 AS id_aula_concluida
                FROM progresso_aula
                WHERE id_usuario = :id_usuario
                AND id_curso = :id_curso
                AND concluida = 1
            ) pa ON a.id = pa.id_aula
            WHERE m.curso_id = :id_curso";
            $stmt_porcentagem = $con->prepare($query_porcentagem);
            $stmt_porcentagem->bindParam(':id_usuario', $id_user);
            $stmt_porcentagem->bindParam(':id_curso', $ID_curso);
            $stmt_porcentagem->execute();

            //seleciona a tabela inscricao para ver o progresso atual
            $query_inscricao = "SELECT progresso FROM inscricao WHERE id_usuario = :id_user AND id_curso = :id_curso";
            $stmt_inscricao = $con->prepare($query_inscricao);
            $stmt_inscricao->bindParam(':id_user', $id_user);
            $stmt_inscricao->bindParam(':id_curso', $ID_curso);
            $stmt_inscricao->execute();

            if ($stmt_porcentagem) {
                $row_porcentagem = $stmt_porcentagem->fetch(PDO::FETCH_ASSOC);
                $porcentagemConclusao = isset($row_porcentagem['porcentagem_concluida']) ? $row_porcentagem['porcentagem_concluida'] : 0;
            

                // Arredonda para no máximo 2 casas decimais
                $porcentagemConclusao = number_format($porcentagemConclusao, 2);

                // Restante do seu código...
            } else {
                echo "<p style='color: #f00;'>Erro: Falha ao executar a consulta de porcentagem!</p>";
            }

            // Forçar o update na tabela 'inscricao'
            $query_forcar_update = "UPDATE inscricao SET progresso = :progresso WHERE id_usuario = :id_user AND id_curso = :id_curso";
            
            // Preparar e executar a query
            try {
                $stmt_forcar_update = $con->prepare($query_forcar_update);
                $stmt_forcar_update->bindParam(':progresso', $porcentagemConclusao);
                $stmt_forcar_update->bindParam(':id_user', $id_user);
                $stmt_forcar_update->bindParam(':id_curso', $ID_curso);
                $stmt_forcar_update->execute();
            
                //echo "Update forçado realizado com sucesso!";
            // da erro caso não aconteça o executar query
            } catch (PDOException $e) {
                echo "Erro ao forçar o update: " . $e->getMessage();
            }
        ?>
        <!-- campo em cima que fica a descrição do curso e aqueles três tópicos do canto direito-->
        <div class="retangulograndecimadetalhes">
            <!-- descrição do curso, com imagem, carga horária, inscritos e etc-->
            <div class="retangulocimaladoddetalhes">
                <!-- imagem do curso -->
                <div class="retangulocimaladoddetalhesimg">
                    <img src="../../COMUM/img/cursos/capa_dos_cursos/<?php echo $row_cursos['imagem'] ?>">
                </div>
                <!-- todas as informações do curso -->
                <div class="retangulocimaladoddetalhestexto">
                    <!-- titulo do curso -->
                    <div class="retangulocimaladoddetalhestitulo">
                        <?php echo $row_cursos['Nome']; ?>
                    </div>
                    <!-- linha embaixo do titulo -->
                    <hr class="linha">
                    <!-- descrição do curso -->
                    <div class="retangulocimaladoddetalhesdescricao">
                        <?php echo substr($row_cursos['Descricao'], 0, 200) . '...';?>
                    </div>
                    <!-- espaço com três informações na mesma linha -->
                    <div class="retangulocimaladoddetalhesopcoes">
                        <!-- carga horária do curso -->
                        <div class="quantidade_modulos">
                            Carga horária: <?php echo $row_cursos['Carga_horaria']; ?> horas
                        </div>
                        <!-- inscritos -->
                        <div class="quantidade_modulos">
                            Inscritos: <?php echo $row_cursos['inscritos']; ?>
                        </div>
                        <!-- botão ver aulas -->
                        <div class="veraulas">
                            <img src="../../COMUM/img/Icons/Preto/play-button2.png">&nbsp; 
                            Ver Aulas
                        </div>
                    </div>
                </div>
            </div>
            <!-- quadrado do canto onde ficam as anotações, aulas favoritas e anexos -->
            <div class="retangulocimaladoedetalhes">
                <!-- anotações -->
                <div class="anotacoesdetalhes">
                    <img class="retangulocimaladoedetalheimg" src="../../COMUM/img/cursos/imagens/notes.png">
                    <div class="detalhesanotacoes">Anotações</div>
                </div>
                <!-- Aulas favoritas -->
                <div class="anotacoesdetalhes">
                    <img class="retangulocimaladoedetalheimg" src="../../COMUM/img/cursos/imagens/label.png">
                    <div class="detalhesanotacoes">Aulas favoritas</div>
                </div>
                <!-- Anexos -->
                <div class="anotacoesdetalhes">
                    <img class="retangulocimaladoedetalheimg" src="../../COMUM/img/cursos/imagens/clipe.png">
                    <div class="detalhesanotacoes">Anexos</div>
                </div>
            </div>
        </div>
        <!--retangulo inferior onde ficam o campo de pesquisa, os módulos e aulas, o progresso atual -->
        <div class="retangulograndebaixodetalhe">
            <!--parte da esquerda onde ficam a pesquisa e os módulos -->
            <div class="retangulograndebaixodetalheesquerda">
                <!-- parte de cima onde tem o campo para digitar e o botão com a lupinha  -->
                <div class="buscardetalhes">
                    <!-- campo para digitar -->
                    <div class="barradebuscadetalhes">
                        <input type="text" name="pesquisadetalhes" class="pesquisadetalhes" id="pesquisadetalhes" placeholder="Digitar...">
                    </div>
                    <!-- botão da lupinha -->
                    <div class="botaobuscadetalhes">
                        <button type="submit" class="lupadetalhes" onclick="return preencherCategoria()">
                            <img src="../../COMUM/img/cursos/imagens/loupe.png">
                        </button>
                    </div>
                </div>
                <!-- Aqui é onde os módulos estão -->
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
                        $result_aulas->bindParam(':curso_id', $ID_curso);
                        $result_aulas->execute();

                        // Consulta para contar o número total de aulas por módulo
                        $query_count_aulas = "SELECT modulo_id, COUNT(*) as total_aulas FROM aulas WHERE modulo_id IN (SELECT id FROM modulos WHERE curso_id=:curso_id) GROUP BY modulo_id";
                        $stmt_count_aulas = $con->prepare($query_count_aulas);
                        $stmt_count_aulas->bindParam(':curso_id', $ID_curso);
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
                                    // cada modulo individual
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
                                                        <p class='aula-titulo'>Aulas: $ordem | Título: $titulo | <a class='botaodetalhes' href='visualizar_aula.php?id_usuario=$id_user&id=$id_aul&modulo_id=$id_mdu&curso_id=$ID_curso'>Concluído</a> | Status: <font color= green> Concluído </font>
                                                    </div>
                                                </div>";
                                        } else {
                                            // Se a aula está em andamento, exibir o botão "Continuar"
                                            echo "<div class='aula'>
                                                    <div class='aula-inner'>
                                                        <p class='aula-titulo'>Aulas: $ordem | Título: $titulo | <a class='botaodetalhes' href='visualizar_aula.php?id_usuario=$id_user&id=$id_aul&modulo_id=$id_mdu&curso_id=$ID_curso'>Continuar</a> | Status: <font color=#4169e1> Em andamento </font> </p>
                                                    </div>
                                                </div>";
                                        }
                                    } else {
                                        // Se não houver registro, a aula ainda não foi iniciada
                                        // Exibir o botão "Começar"
                                        echo "<div class='aula'>
                                                <div class='aula-inner'>
                                                    <p class='aula-titulo'>Aulas: $ordem | Título: $titulo | <a class='botaodetalhes' href='php/iniciar_aula.php?id_usuario=$id_user&id_aula=$id_aul&modulo_id=$id_mdu&curso_id=$ID_curso'>Começar</a> | Status: <font color= red> Não iniciado </font> 
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
                <?php } ?>
                <!-- Aqui é onde a barra de progresso e o texto falando sobre a barra de progresso estão -->
                <div class="retangulograndebaixodetalhedireita">
                    <!-- titulo da barra de progresso -->
                    <div class="detalheprogresso">
                        Seu Progresso Atual
                    </div>
                    <!-- barra de progresso  -->
                    <div class="progressobarradetalhes">
                        <!-- barra de progresso em sí -->
                        <div class="progresso-barra-detalhes" style="width: <?php echo $porcentagemConclusao; ?>%">
                            <!-- textinho dentro da barra de progresso mostrando a porcentagem de quanto ela está completa -->
                            <span class="progresso-texto-detalhes">
                                <?php
                                    if($porcentagemConclusao == 0){
                                        echo "0%";
                                    }else{
                                        echo $porcentagemConclusao."%";
                                    } 
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
        </div>
        <!-- javascript -->
        <script src="js/darkmode.js"></script>
        <script src="js/zoom.js"></script>
        <script src="js/modulos.js"></script>
    </body>
</html>