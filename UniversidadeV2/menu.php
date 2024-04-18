<!DOCTYPE html>
<html lang="pt-br">
    <?php
        //inclui a página que mantem o site conectado no banco de dados
        include_once("php/conexao.php");

        //faz uma busca no banco de dados e retorna tudo o que for do usuário atual
        $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
        $resultado_usuario = mysqli_query($conn, $result_usuario);

        // salva algumas informações do usuário atual em variaveis para facilitar
        if ($row_usuario = mysqli_fetch_assoc($resultado_usuario)) {
            $id_user = $row_usuario['ID_usuario'];
            $dep = $row_usuario['Dep'];
            $nome_usuario = $row_usuario['Nome'];
            $abreviacao = $row_usuario['Abreviacao'];
        }

        // Consulta para contar o número de aulas concluídas pelo usuário
        $query_aulas_concluidas = "
            SELECT COUNT(*) AS aulas_concluidas
            FROM progresso_aula
            WHERE id_usuario = $id_user
            AND concluida = 1
        ";

        // Executar a consulta das aulas concluídas
        $result_aulas_concluidas = mysqli_query($conn, $query_aulas_concluidas);

        if ($result_aulas_concluidas) {
            $row_aulas_concluidas = mysqli_fetch_assoc($result_aulas_concluidas);
            $aulas_concluidas = $row_aulas_concluidas['aulas_concluidas'];
        } else {
            $aulas_concluidas = 0; // Se houver erro na consulta, definir como 0
        }

        // Exibir o número total de aulas concluídas pelo usuário
        //echo "Total de aulas concluídas: " . $aulas_concluidas;

    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu Versão 2</title>
        <!--coloca o icone na aba da tela-->
        <link rel="icon" type="png" href="../../COMUM/img/Icons/Vermelho/imgML13.png">
        <!--CSS-->
        <link href="https://fonts.cdnfonts.com/css/community" rel="stylesheet">
        <link rel="stylesheet" href="css/tudo.css">
    </head>
    <body>
        <!--pega o titulo (menu superior) e coloca na página--> 
        <?php require "titulo.php";?>
        <!-- Aqui tem o retangulo grande do menu-->
        <div class="retangulog">
            <?php   
                // Verificar se o usuário está acessando pela primeira vez
                $pesquisa = "SELECT COUNT(*) AS total FROM inscricao WHERE id_usuario = '$id_user'";
                $resultado_pesquisa = mysqli_query($conn, $pesquisa);
                
                // pega o resultado da busca feita anteriormente e salva em variaveis
                if ($resultado_pesquisa) {
                    $row = mysqli_fetch_assoc($resultado_pesquisa);
                    $total_inscricoes = $row['total'];

                    // se total de inscrições == 0
                    if ($total_inscricoes == 0) {
                        // O usuário está acessando pela primeira vez, então recuperamos o curso mais recente
                        $pesquisa_curso_recente = "SELECT * FROM curso ORDER BY Datadecriacao DESC LIMIT 1";
                        $resultado_curso_recente = mysqli_query($conn, $pesquisa_curso_recente);

                        if ($resultado_curso_recente && mysqli_num_rows($resultado_curso_recente) > 0) {
                            $curso_recente = mysqli_fetch_assoc($resultado_curso_recente);
                            // Exibir o curso mais recente
                            // Você pode adicionar aqui o HTML para exibir os detalhes do curso
                        ?>
                            <!-- retangulo do topo onde tem na esquerda o curso mais recente ou último curso cadastrado não terminado, e na direita o nome em cima e embaixo algumas pontuações  -->
                            <div class="quadradoumfundo">
                                <!-- retangulo dourado que fica atrás do curso -->
                                <div class="quadradodefundo"></div>
                                    <!-- retangulo onde ficam o titulo, a descrição e a barra de progresso -->
                                    <div class="quadradoum">
                                        <div class="quadradoumescrito">
                                            <div class="quadradoumtitulo">
                                                <?php echo $curso_recente['Nome']; ?>
                                            </div>
                                            <div class="quadradoumnome">
                                                Instrutor: <?php echo $curso_recente['Autor']; ?>
                                            </div>
                                            <div class="quadradoumdescricao">
                                                Descrição: <?php echo substr($curso_recente['Descricao'], 0, 210) . '...'; ?>
                                            </div>
                                            <div class="seuprogresso">
                                                <!--Seu Progresso-->
                                            </div>
                                        </div>
                                        <div class="imagemcanto">
                                            <img src="../../COMUM/img/cursos/capa_dos_cursos/<?php echo $curso_recente['imagem']; ?>">
                                        </div>
                                        <div class="opcoesbanner">
                                            <!--<div class="progresso">
                                                <div class="progresso-barra" style="width: <?php //echo $curso_recente['progresso']?>%">
                                                    <span class="progresso-texto">
                                                        <?php //echo $curso_recente['progresso']?>
                                                    </span>
                                                </div>
                                            </div>-->
                                            <a href="detalhes.php?ID_curso=<?php echo $curso_recente['ID_curso'];?>&progresso=2&Usuario=<?php echo $usuario;?>">
                                                <button class="buttoncontinuar">
                                                    <img src="../../COMUM/img/Icons/Preto/play-button2.png">&nbsp; <p>Comece Agora</p>
                                                </button>
                                            </a>
                                        </div>
                                    </div> 
                            </div>
                        <?php
                        } else {
                            echo "Nenhum curso encontrado.";
                        }
                    } else {
                        // O usuário já acessou cursos anteriormente, então verificamos se todos os cursos foram concluídos
                        $pesquisa_cursos_concluidos = "SELECT COUNT(*) AS total_concluidos FROM inscricao WHERE id_usuario = '$id_user' AND progresso = 100";
                        $resultado_cursos_concluidos = mysqli_query($conn, $pesquisa_cursos_concluidos);
                        
                        if ($resultado_cursos_concluidos) {
                            $row_cursos_concluidos = mysqli_fetch_assoc($resultado_cursos_concluidos);
                            $total_cursos_concluidos = $row_cursos_concluidos['total_concluidos'];

                            if ($total_cursos_concluidos == $total_inscricoes) {
                                // Todos os cursos foram concluídos, então recuperamos o último curso que o usuário ainda não acessou
                                $pesquisa_ultimo_curso_nao_acessado = "SELECT * FROM curso WHERE ID_curso NOT IN (SELECT id_curso FROM inscricao WHERE id_usuario = '$id_user') ORDER BY Datadecriacao DESC LIMIT 1";
                                $resultado_ultimo_curso_nao_acessado = mysqli_query($conn, $pesquisa_ultimo_curso_nao_acessado);
                                
                                if ($resultado_ultimo_curso_nao_acessado && mysqli_num_rows($resultado_ultimo_curso_nao_acessado) > 0) {
                                    $ultimo_curso_nao_acessado = mysqli_fetch_assoc($resultado_ultimo_curso_nao_acessado);
                                    // Exibir o último curso que o usuário não acessou
                                    // Você pode adicionar aqui o HTML para exibir os detalhes do curso
                                ?>
                                    <div class="quadradoumfundo">
                                        <div class="quadradoum">
                                            <div class="quadradoumescrito">
                                                <div class="quadradoumtitulo">
                                                    <?php echo $ultimo_curso_nao_acessado['Nome']; ?>
                                                </div>
                                                <div class="quadradoumnome">
                                                    Instrutor: <?php echo $ultimo_curso_nao_acessado['Autor']; ?>
                                                </div>
                                                <div class="quadradoumdescricao">
                                                    Descrição: <?php echo substr($ultimo_curso_nao_acessado['Descricao'], 0, 210) . '...'; ?>
                                                </div>
                                                <!--<div class="seuprogresso">
                                                    Seu Progresso
                                                </div>-->
                                            </div>
                                            <div class="imagemcanto">
                                                <img src="../../COMUM/img/cursos/capa_dos_cursos/<?php echo $ultimo_curso_nao_acessado['imagem']; ?>">
                                            </div>
                                            <div class="opcoesbanner">
                                               <!--<div class="progresso">
                                                    <div class="progresso-barra" style="width: <?php echo $ultimo_curso_nao_acessado['progresso']?>%">
                                                        <span class="progresso-texto">
                                                            <?php //echo $ultimo_curso_nao_acessado['progresso']?>%
                                                        </span>
                                                    </div>
                                                </div>-->
                                                <a href="detalhes.php?ID_curso=<?php echo $ultimo_curso_nao_acessado['ID_curso'];?>&progresso=2&Usuario=<?php echo $usuario;?>">
                                                    <button class="buttoncontinuar">
                                                        <img src="../../COMUM/img/Icons/Preto/play-button2.png">&nbsp; <p>Comece Agora</p>
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="quadradodefundo"></div>
                                    </div>
                                <?php
                                } else {
                                    echo "Nenhum curso encontrado.";
                                }
                            } else {
                                //Alguns cursos ainda não foram concluídos
                                // Exibir os cursos em progresso
                                // Aqui você pode continuar com a lógica que já tem para exibir os cursos com progresso diferente de 100%
                                // Alguns cursos ainda não foram concluídos
                                // Recuperar os cursos em andamento do usuário
                                $query_cursos_em_andamento = "SELECT inscricao.id_curso, curso.Nome, curso.Autor, curso.Descricao, curso.imagem, inscricao.progresso
                                FROM curso
                                INNER JOIN inscricao ON curso.ID_curso = inscricao.id_curso
                                WHERE inscricao.id_usuario = '$id_user' AND inscricao.progresso < 100
                                ORDER BY inscricao.data_de_inscricao DESC LIMIT 1";                            

                                $resultado_cursos_em_andamento = mysqli_query($conn, $query_cursos_em_andamento);

                                if ($resultado_cursos_em_andamento && mysqli_num_rows($resultado_cursos_em_andamento) > 0) {
                                    // Exibir os cursos em andamento
                                    while ($curso_em_andamento = mysqli_fetch_assoc($resultado_cursos_em_andamento)) {
                                    ?>
                                        <div class="quadradoumfundo">
                                            <div class="quadradoum">
                                                <div class="quadradoumescrito">
                                                    <div class="quadradoumtitulo">
                                                        <?php echo $curso_em_andamento['Nome']; ?>
                                                    </div>
                                                    <div class="quadradoumnome">
                                                        Instrutor: <?php echo $curso_em_andamento['Autor']; ?>
                                                    </div>
                                                    <div class="quadradoumdescricao">
                                                        Descrição: <?php echo substr($curso_em_andamento['Descricao'], 0, 210) . '...'; ?>
                                                    </div>
                                                    <!--<div class="seuprogresso">
                                                        Seu Progresso: <?php //echo $curso_em_andamento['progresso']; ?>%
                                                    </div>-->
                                                </div>
                                                <div class="imagemcanto">
                                                    <img src="../../COMUM/img/cursos/capa_dos_cursos/<?php echo $curso_em_andamento['imagem']; ?>">
                                                </div>
                                                <div class="opcoesbanner">
                                                    <div class="progresso">
                                                        <div class="progresso-barra" style="width: <?php echo $curso_em_andamento['progresso']; ?>%">
                                                            <span class="progresso-texto">
                                                                <?php echo $curso_em_andamento['progresso']; ?>%
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <a href="detalhes.php?ID_curso=<?php echo $curso_em_andamento['id_curso'];?>&progresso=0&Usuario=<?php echo $usuario;?>">
                                                        <button class="buttoncontinuar">
                                                            <img src="../../COMUM/img/Icons/Preto/play-button2.png">&nbsp; <p>Continuar Assistindo</p>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="quadradodefundo"></div>
                                        </div>
                            <?php
                                    }
                                } else {
                                echo "Nenhum curso em andamento encontrado.";
                                }
                            }
                        } else {
                            echo "Erro na execução da consulta: " . mysqli_error($conn);
                        }
                    }
                } else {
                    echo "Erro na execução da consulta: " . mysqli_error($conn);
                }
            ?>
            <!-- lado esquerdo cima onde ficam o nome e a pontuação -->
            <div class="quadradodois">
                <!-- Onde fica a abreviação e o nome -->
                <div class="retangulopequeno">
                    <!-- Abreviação -->
                    <div class="nome_abreviado_quadrado"><?php echo $abreviacao; ?></div>
                    <!-- Nome completo e departamento -->
                    <div class="ladoalado">
                        <!-- Nome -->
                        <div class="nome_completo"><?php echo $nome_usuario;?></div>
                        <!-- Departamento -->
                        <div class="membro"><?php echo $dep; ?></div>
                    </div>
                </div>
                <!-- area da pontuação -->
                <div class="sequencia_de_quadrados_pequenos">
                    <!-- Pontos de Experiência -->
                    <div class="quadrado_pequeno_um">
                        <!-- imagem -->
                        <div class="imagem_quadrado_pequeno">
                            <img class="imagem_quadrado_pequeno_um" src="../../COMUM/img/Icons/Preto/badge.png"><br>
                        </div>
                        <!-- numero da pontuação -->
                        <div class="titulo_quadrado_pequeno_um">0</div>
                        <!-- título -->
                        <div class="texto_quadrado_pequeno_um">Pontos de Experiência</div>
                    </div>
                    <!-- Aulas concluídas -->
                    <div class="quadrado_pequeno_dois">
                        <!-- imagem -->
                        <div class="imagem_quadrado_pequeno">
                            <img class="imagem_quadrado_pequeno_um" src="../../COMUM/img/Icons/Preto/book.png"><br>
                        </div>
                        <!-- numero da pontuação -->
                        <div class="titulo_quadrado_pequeno_um"><center><?php echo $aulas_concluidas; ?></center></div>
                        <!-- título -->
                        <div class="texto_quadrado_pequeno_um">Aulas Concluídas</div>
                    </div>
                    <!-- Melhores Respostas -->
                    <div class="quadrado_pequeno_tres">
                        <!-- imagem -->
                        <div class="imagem_quadrado_pequeno">
                            <img class="imagem_quadrado_pequeno_um" src="../../COMUM/img/Icons/Preto/trophy.png"><br>
                        </div>
                        <!-- numero da pontuação -->
                        <div class="titulo_quadrado_pequeno_um">0</div>
                         <!-- título -->
                        <div class="texto_quadrado_pequeno_um">Melhores Respostas</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- parte de baixo-->
        <div class="tudo_dois">
            <!-- parte de baixo esquerda -->
            <div class="ladoesquerdo_dois">
                <!-- parte do está com dúvidas de qual conteúdo seguir -->
                <div class="duvida">
                    <!-- texto -->
                    <h6 class="duvidatexto">Está com dúvidas de qual conteúdo seguir?</h6>
                    <!-- botão ver mapa da jornada + imagem do mapinha -->
                    <button class="mapadajornada">
                        <img src="../../COMUM/img/cursos/imagens/map.png">
                            <div class="text_button">
                                VER MAPA DA JORNADA
                            </div>
                    </button>
                </div>
                <!-- botões cursos recentes, novos cursos, grupos INTERESSANTES -->
                <div class="botoescomopcoes">
                    <!-- Cursos recentes -->
                    <button class="profissoes_digitais ativo" id="btn_profissoes_digitais">
                        <img class="botao_imagem_tras" src="../../COMUM/img/cursos/imagens/mala.png">
                        <div class="button_texto_olha">
                            CURSOS RECENTES
                        </div>
                        <img class="botao_imagem_frente" src="../../COMUM/img/cursos/imagens/informacoes.png">
                    </button>
                    <!-- novos cursos -->
                    <button class="insights" id="btn_insights">
                        <img class="botao_imagem_tras" src="../../COMUM/img/cursos/imagens/lampada.png">
                        <div class="button_texto_olha">
                            NOVOS CURSOS
                        </div>
                        <img class="botao_imagem_frente" src="../../COMUM/img/cursos/imagens/informacoes.png">
                    </button>
                    <!-- grupos interessantes -->
                    <button class="caixa_de_ferramentas" id="btn_caixa_de_ferramentas">
                        <img class="botao_imagem_tras" src="../../COMUM/img/cursos/imagens/wrench.png">
                        <div class="button_texto_olha">
                            GRUPOS INTERESSANTES
                        </div>
                        <img class="botao_imagem_frente" src="../../COMUM/img/cursos/imagens/informacoes.png">
                    </button>
                </div>
                <!-- aqui é a parte que mostra todos os cursos mais recentes cadastrados -->
                <div class="profissoesdigitais">
                    <!-- titulo -->
                    <div class="profissoesdigitais_titulo">
                        <div class="titulo_profissoes">
                            Cursos Recentes
                        </div>
                        <!-- botão -->
                        <button class="vermais">+ Ver Todos</button>
                    </div>
                    <!-- texto -->
                    <div class="texto_profissoes">Aqui você vai aprender diversos tipos de informações do zero e já sair com chances reais de resultado</div>
                    <!--
                        futuras atualizações
                        <div class="botoes-orbs">
                        <div class="orb orb-cheia"></div>
                        <div class="orb orb-vazia"></div>
                    </div>-->
                    <!-- 4 cursos mais recentes colocados no banco de dados -->
                    <div class="bannersprofissoes">
                    <?php
                        // buca no bando de dados todos os cursos mais recentes cadastrados
                        $query_cursos_recentes = "SELECT * FROM curso ORDER BY Datadecriacao DESC LIMIT 4"; // Obtém os 4 cursos mais recentes
                        $result_cursos_recentes = mysqli_query($conn, $query_cursos_recentes);

                        if ($result_cursos_recentes) {
                            while ($row = mysqli_fetch_assoc($result_cursos_recentes)) {
                                
                                // Verificar se o usuário está inscrito neste curso
                                $query_verificar_inscricao = "SELECT * FROM inscricao WHERE id_usuario = $id_user AND id_curso = {$row['ID_curso']}";
                                $resultado_verificar_inscricao = mysqli_query($conn, $query_verificar_inscricao);
                                $usuarioInscrito = (mysqli_num_rows($resultado_verificar_inscricao) > 0);

                                // Verificar o progresso do usuário neste curso
                                $testador = 0; // Valor padrão se o usuário não estiver inscrito
                                if ($usuarioInscrito) {
                                    $inscricao = mysqli_fetch_assoc($resultado_verificar_inscricao);
                                    $testador = $inscricao['progresso'];
                                }
                                if ($testador == 100) {
                                    // Se o progresso for 100%, exibir o botão "Completo"
                                    echo "<a href='detalhes.php?ID_curso={$row['ID_curso']}&progresso=100&Usuario={$usuario}'>";
                                } elseif ($usuarioInscrito) {
                                    // Usuário está inscrito, exibir o botão "Continuar"
                                    echo "<a href='detalhes.php?ID_curso={$row['ID_curso']}&progresso=0&Usuario={$usuario}'>";
                                } else {
                                    // Usuário não está inscrito, exibir o botão "Inscrever-se"
                                    echo "<a href='detalhes.php?ID_curso={$row['ID_curso']}&progresso=2&Usuario={$usuario}'>";
                                }
                                //echo "<a href=''>";

                                echo "<div class='bannersprofissoes_um'>";
                                echo "<div class='bannersprofissoes_frente'>
                                        <img src='../../COMUM/img/cursos/capa_dos_cursos/{$row['imagem']}'>
                                      </div>";

                                // Verifica o valor da subcategoria
                                $query_subcategoria = "SELECT Nome FROM subcategoria WHERE id = {$row['Subcategoria']}";
                                $result_subcategoria = mysqli_query($conn, $query_subcategoria);

                                if ($result_subcategoria && mysqli_num_rows($result_subcategoria) > 0) {
                                    $subcategoria = mysqli_fetch_assoc($result_subcategoria)['Nome'];
                                } else {
                                    // Caso a subcategoria não exista ou a consulta falhe, defina um valor padrão
                                    $subcategoria = "Não especificada";
                                }

                                // Verifica o valor da subcategoria
                                if ($row['Subcategoria'] == 1) {
                                    echo "<div class='bannersprofissoes_imagem'>
                                                <img src='../../COMUM/img/cursos/imagens/impressora.png'></div>";
                                } elseif ($row['Subcategoria'] == 4) {
                                    echo "<div class='bannersprofissoes_imagem'><img src='../../COMUM/img/cursos/imagens/codificacao.png'></div>";
                                } elseif ($row['Subcategoria'] == 2) {
                                    echo "<div class='bannersprofissoes_imagem'><img src='../../COMUM/img/cursos/imagens/departamento-de-informatica.png'></div>";
                                } else {
                                    // Se a subcategoria não corresponder a nenhum dos valores esperados, exibe uma imagem padrão
                                    echo "<div class='bannersprofissoes_imagem'><img src='caminho/para/imagem/padrao.png'></div>";
                                }
                                echo "<div class='bannersprofissoes_cat'>{$subcategoria}</div>";
                                echo "<div class='bannersprofissoes_nome'>{$row['Nome']}</b></div>";
                                echo "</div></a>";
                            }
                        } else {
                            echo "Erro na execução da consulta: " . mysqli_error($conn);
                        }
                    ?>
                    </div>
                </div>     
            </div>
            <!-- lado direito inferior -->
            <div class="ladodireito_dois">
                <!-- titulo acesso rápido -->
                <div class="titulodireito">
                    Acesso Rápido
                </div>
                <!-- imagem  que fica embaixo do titulo--> 
                <div class="imagemdireito">
                    <img class="imagempequenadocanto" src="../../COMUM/img/cursos/imagens/study.jpg">
                </div>
                <!-- Campo com informações extras -->
                <div class="informacoesextras">
                    <!-- Atualizar perfil -->
                    <a href="">
                        <div class="atualizarperfil">
                            <img class="imagemlateralesquerda" src="../../COMUM/img/cursos/imagens/perfil.png">
                            <div class="textolateraldireita">ATUALIZAR PERFIL</div>
                        </div>
                    </a>
                    <!-- Instagram -->
                    <a href="">
                        <div class="atualizarperfil">
                            <img class="imagemlateralesquerda" src="../../COMUM/img/cursos/imagens/instagram.png">
                            <div class="textolateraldireita">INSTAGRAM</div>
                        </div>
                    </a>
                    <!-- Comunidade -->
                    <a href="">
                        <div class="atualizarperfil">
                            <img class="imagemlateralesquerda" src="../../COMUM/img/cursos/imagens/grupo.png">
                            <div class="textolateraldireita">COMUNIDADE</div>
                        </div>
                    </a>
                    <!-- Anotações -->
                    <a href="">
                        <div class="atualizarperfil">
                            <img class="imagemlateralesquerdaanotacao" src="../../COMUM/img/cursos/imagens/notes.png">
                            <div class="textolateraldireita">Anotações</div>
                        </div>
                    </a>
                    <!-- Aulas favoritas -->
                    <a href="">
                        <div class="atualizarperfil">
                            <img class="imagemlateralesquerda" src="../../COMUM/img/cursos/imagens/label.png">
                            <div class="textolateraldireita">Aulas favoritas</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!--Rodapé-->
        <?php require "rodape.php"; ?>
        <!--javascript-->
        <script src="js/menu.js"></script>
        <script src="js/darkmode.js"></script>
    </body>
</html>