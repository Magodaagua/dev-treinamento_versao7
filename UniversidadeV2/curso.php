<!DOCTYPE html>
<html lang="pt-br">
    <?php
        //conexão com o banco de dados
        include_once("php/conexao.php");

        //pega informações passadas pela URL
        $categoria = isset($_GET['Dep']) ? $_GET['Dep'] : null;
        $subcategoria = isset($_GET['subcategoria']) ? $_GET['subcategoria'] : null;
        $usuario = $_SESSION['Usuario'];

        // Incluir o script JavaScript e definir a variável categoria dentro dele
        echo '<script>';
        echo 'const categoria = "' . $categoria . '";'; // Definindo a variável categoria em JavaScript com o valor do PHP
        echo '</script>';

        // retorna todas as informações da categoria
        $result_categoria = "SELECT * FROM categoria WHERE Nome_cat = '$categoria'";
        $resultado_categoria = mysqli_query($conn, $result_categoria);

        if ($resultado_categoria) {
            $row_categoria = mysqli_fetch_assoc($resultado_categoria);
            $id_categoria_atual = $row_categoria['id'];
        } else {
            // Trate o erro, se houver algum
            echo "Erro na consulta: " . mysqli_error($conn);
        }

        //faz uma busca para pegar todas as informações dos usuários
        $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
        $resultado_usuario = mysqli_query($conn, $result_usuario);

        if ($row_usuario = mysqli_fetch_assoc($resultado_usuario)) {
            $id_user = $row_usuario['ID_usuario'];
            $dep = $row_usuario['Dep'];
            $nome_usuario = $row_usuario['Nome'];
            $abreviacao = $row_usuario['Abreviacao'];

        }

        //Selecionar todos os cursos que o usuário está inscrito
        $result_inscricao = "SELECT * FROM inscricao WHERE id_usuario = '$id_user'";
        $resultado_inscricao = mysqli_query($conn, $result_inscricao);

        $query_cursos = "SELECT * FROM curso WHERE Categoria = '$id_categoria_atual'";
        // Query para obter o total de cursos na categoria informática com filtro de subcategoria
        if($subcategoria && $subcategoria !== 'default'){
            $total_cursos_query = "SELECT COUNT(*) AS total FROM curso WHERE Categoria = '$id_categoria_atual' AND Subcategoria = '$subcategoria'";
            $resultado_total_cursos = mysqli_query($conn, $total_cursos_query);
            $row_total_cursos = mysqli_fetch_assoc($resultado_total_cursos);
            $total_de_cursos = $row_total_cursos['total'];
        }
        // Query para obter o total de cursos na categoria informática
        else{
            $total_cursos_query = "SELECT COUNT(*) AS total FROM curso WHERE Categoria = '$id_categoria_atual'";
            $resultado_total_cursos = mysqli_query($conn, $total_cursos_query);
            $row_total_cursos = mysqli_fetch_assoc($resultado_total_cursos);
            $total_de_cursos = $row_total_cursos['total'];
        }

        //Selecionar os cursos a serem apresentados na página pela subcategoria
        //$result_cursos = "SELECT ID_curso, Nome, Categoria, Subcategoria, Descricao, Datadecriacao, Carga_horaria, inscritos, imagem, valido FROM curso WHERE Categoria = '$categoria' limit $inicio, $quantidade_pg";
        if($subcategoria && $subcategoria !== 'default'){
            $result_cursos = "SELECT ID_curso, Nome, Categoria, Subcategoria, Descricao, Datadecriacao, Carga_horaria, inscritos, imagem FROM curso WHERE Categoria = '$id_categoria_atual' AND Subcategoria = '$subcategoria'";
            $resultado_cursos = mysqli_query($conn, $result_cursos);
            $total_cursos = mysqli_num_rows($resultado_cursos);
        }
        //Selecionar os cursos a serem apresentados na página
        else{
            $result_cursos = "SELECT ID_curso, Nome, Categoria, Subcategoria, Descricao, Datadecriacao, Carga_horaria, inscritos, imagem FROM curso WHERE Categoria = '$id_categoria_atual'";
            $resultado_cursos = mysqli_query($conn, $result_cursos);
            $total_cursos = mysqli_num_rows($resultado_cursos);
        }

    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Curso Versão 2</title>
        <!--coloca o icone na aba da tela-->
        <link rel="icon" type="png" href="../../COMUM/img/Icons/Vermelho/imgML13.png">
        <!--CSS-->
        <link rel="stylesheet" href="css/tudo.css">
    </head>
    <body>
        <?php 
            //menu superior
            require "titulo.php"; 
        ?>
        <!-- menu com o os dois filtros e a pesquisa -->
        <div class="menudepesquisa">
            <!-- nomes que ficam em cima para ver qual fltro/pesquisa é -->
            <div class="titulodepesquisa">
                <div class="titulodepesquisaum">Nível</div>
                <div class="titulodepesquisadois">Categoria</div>
                <div class="titulodepesquisatres">Título</div>
            </div>
            <!--os campos de busca e filtro -->
            <div class="campodepesquisa">
                <!-- filtro 1 -->
                <div class="selecionarpesquisaum">
                    <select name="Nivel" id="Nivel" onchange="filtrarNivel()">
                        <option value="default">Selecione um nível</option>
                    </select>
                </div>
                <!-- filtro 2 esse é o filtro por subcategoria -->
                <div class="selecionarpesquisadois">
                    <select name="Categoria" id="Categoria" onchange="filtrarCursos()">
                        <option value="default">Selecione uma categoria</option>
                        <?php
                            $result_cat_post = "SELECT * FROM subcategoria WHERE ID_categoria = $id_categoria_atual ORDER BY Nome ";
                            $resultado_cat_post = mysqli_query($conn, $result_cat_post);

                            while($row_cat_post = mysqli_fetch_assoc($resultado_cat_post)) {
                                $selected = ($row_cat_post['id'] == $subcategoria) ? 'selected' : '';
                                echo '<option value="'.$row_cat_post['id'].'" ' . $selected . '>'.$row_cat_post['Nome'].'</option>';
                            }
                        ?>
                    </select>
                </div>
                <!-- Campo de pesquisa aqui você digita o nome do curso que vai pesquisar -->
                <div class="pesquisaescrita">
                    <form class="formulariopesquisaescrita" method="GET" action="pesquisa.php">
                        <div class="formulariogrupo">
                            <input type="text" name="pesquisar" class="pesquisapornome" id="pesquisapornome" placeholder="Digitar...">
                            <input type="hidden" name="categoria" id="categoria" value="<?php echo $categoria; ?>">
                        </div>
                        <div class="botaodepesquisa">
                            <button type="submit" class="pesquisar" onclick="return preencherCategoria()">
                                <img src="../../COMUM/img/cursos/imagens/loupe.png">
                            </button>
                        </div>
                        <div class="botaodeapagar">
                            <button id="LimparFiltro" class="LimparFiltro" onclick="limparFiltro()">
                                    <img src="../../COMUM/img/cursos/imagens/broom.png">
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Aqui é onde aparecem todos os cursos-->
        <div class="retangulocursos">
            <?php
                //busca todos os cursos pela departamento do cliente
                $query_cursos_recentes = "SELECT * FROM curso WHERE Categoria = '$id_categoria_atual'";

                //se tiver subcategoria envia também senão não busca
                if ($subcategoria && $subcategoria !== 'default') {
                    $query_cursos_recentes .= " AND Subcategoria = '$subcategoria'";
                }
                //acrescenta na busca um filtro de mais novo aparece antes
                $query_cursos_recentes .= " ORDER BY Datadecriacao DESC";
                //salva todos os resultados da busca
                $result_cursos_recentes = mysqli_query($conn, $query_cursos_recentes);

                //se retornar algo dos resultados
                if ($result_cursos_recentes) {
                    while ($row = mysqli_fetch_assoc($result_cursos_recentes)) {
                        echo "<div class='bannersprofissoes_dois'>";
                        echo "<div class='bannersprofissoes_frente'>
                                <img src='../../COMUM/img/cursos/capa_dos_cursos/{$row['imagem']}'>
                            </div>";

                        // Verifica o valor da subcategoria do curso
                        $query_subcategoria = "SELECT Nome FROM subcategoria WHERE id = {$row['Subcategoria']}";
                        $result_subcategoria = mysqli_query($conn, $query_subcategoria);

                        if ($result_subcategoria && mysqli_num_rows($result_subcategoria) > 0) {
                            $subcategoria = mysqli_fetch_assoc($result_subcategoria)['Nome'];
                        } else {
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

                        // Limitar o nome do curso
                        $nome_truncado = (mb_strlen($row['Nome'], 'UTF-8') > 20) ? mb_substr($row['Nome'], 0, 20, 'UTF-8') . '...' : $row['Nome'];
                        echo "<div class='bannersprofissoes_nome'>" . $nome_truncado . "</div>";

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

                        echo "<div class='botaocurso'>";
                        if ($testador == 100) {
                            // Se o progresso for 100%, exibir o botão "Completo"
                            echo "<a href='detalhes.php?ID_curso={$row['ID_curso']}&progresso=100&Usuario={$usuario}'><button type='button' class='botaofinalizado'>Concluído</button></a>";
                        } elseif ($usuarioInscrito) {
                            // Usuário está inscrito, exibir o botão "Continuar"
                            echo "<a href='detalhes.php?ID_curso={$row['ID_curso']}&progresso=0&Usuario={$usuario}'><button type='button' class='botaocontinuar'>Continuar</button></a>";
                        } else {
                            // Usuário não está inscrito, exibir o botão "Inscrever-se"
                            echo "<a href='detalhes.php?ID_curso={$row['ID_curso']}&progresso=2&Usuario={$usuario}'><button type='button' class='botaoinscricao'>Inscrever-se</button></a>";
                        }
                        echo "</div>";

                        echo "</div>";
                    }
                //se não erro de conexão
                } else {
                    echo "Erro na execução da consulta: " . mysqli_error($conn);
                }
            ?>
        </div>
        <!-- rodapé da página-->
        <?php require "rodape.php"; ?>
        <!-- javascript -->
        <script src="js/darkmode.js"></script>
        <script src="js/zoom.js"></script>
        <script src="js/filtro.js"></script>
    </body>
</html>