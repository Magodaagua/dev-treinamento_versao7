<!DOCTYPE html>
<html lang="pt-br">
    <?php
        //conexão com banco de dados
        include_once("php/conexao.php");

        //pega todos os itens passados pela URL
        $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;
        $subcategoria = isset($_GET['subcategoria']) ? $_GET['subcategoria'] : null;
        $valor_pesquisar = isset($_GET['pesquisar']) ? $_GET['pesquisar'] : null;

        // Incluir o script JavaScript e definir a variável categoria dentro dele
        echo '<script>';
        echo 'const categoria = "' . $categoria . '";'; // Definindo a variável categoria em JavaScript com o valor do PHP
        echo '</script>';

        // Ajuste na consulta para incluir a categoria apenas se estiver definida
        if (!empty($categoria)) {
            $categoria_condicional = " AND Categoria = '$id_categoria_atual'";
        } else {
            $categoria_condicional = "";
        }

        // Executar a consulta apenas se o valor de pesquisa não estiver vazio
        if (!empty($valor_pesquisar)) {
            $result_curso = "SELECT * FROM curso WHERE Nome LIKE '%$valor_pesquisar%' $categoria_condicional";
            $resultado_curso = mysqli_query($conn, $result_curso);
        }

        // retorna todas as informações da categoria que foi passada pela url
        $result_categoria = "SELECT * FROM categoria WHERE Nome_cat = '$categoria'";
        $resultado_categoria = mysqli_query($conn, $result_categoria);

        // se retornar algum valor da pesquisa a cima salva a id da categoria
        if ($resultado_categoria) {
            $row_categoria = mysqli_fetch_assoc($resultado_categoria);
            $id_categoria_atual = $row_categoria['id'];
        // se não erro
        } else {
            // Trate o erro, se houver algum
            echo "Erro na consulta: " . mysqli_error($conn);
        }

        //faz uma busca para pegar todas as informações do usuário e salva em variaveis locais
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
        // Query para obter o total de cursos na categoria informática
        if($subcategoria && $subcategoria !== 'default'){
            $total_cursos_query = "SELECT COUNT(*) AS total FROM curso WHERE Categoria = '$id_categoria_atual' AND Subcategoria = '$subcategoria'";
            $resultado_total_cursos = mysqli_query($conn, $total_cursos_query);
            $row_total_cursos = mysqli_fetch_assoc($resultado_total_cursos);
            $total_de_cursos = $row_total_cursos['total'];
        }
        else{
            $total_cursos_query = "SELECT COUNT(*) AS total FROM curso WHERE Categoria = '$id_categoria_atual'";
            $resultado_total_cursos = mysqli_query($conn, $total_cursos_query);
            $row_total_cursos = mysqli_fetch_assoc($resultado_total_cursos);
            $total_de_cursos = $row_total_cursos['total'];
        }

        //Selecionar os cursos a serem apresentados na página
        //$result_cursos = "SELECT ID_curso, Nome, Categoria, Subcategoria, Descricao, Datadecriacao, Carga_horaria, inscritos, imagem, valido FROM curso WHERE Categoria = '$categoria' limit $inicio, $quantidade_pg";
        if($subcategoria && $subcategoria !== 'default'){
            $result_cursos = "SELECT ID_curso, Nome, Categoria, Subcategoria, Descricao, Datadecriacao, Carga_horaria, inscritos, imagem FROM curso WHERE Categoria = '$id_categoria_atual' AND Subcategoria = '$subcategoria'";
            $resultado_cursos = mysqli_query($conn, $result_cursos);
            $total_cursos = mysqli_num_rows($resultado_cursos);
        }
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
            // menu superior
            require "titulo.php"; 
        ?>
        <!-- parte de cima aonde fica a pesquisa do site -->
        <div class="menudepesquisa">
            <!-- titulos encima dos campos de pesquisa -->
            <div class="titulodepesquisa">
                <div class="titulodepesquisaum">Nível</div>
                <div class="titulodepesquisadois">Categoria</div>
                <div class="titulodepesquisatres">Título</div>
            </div>
            <!-- campos de pesquisa -->
            <div class="campodepesquisa">
                <!-- filtro 1 -->
                <div class="selecionarpesquisaum">
                    <select name="Nivel" id="Nivel" onchange="filtrarNivel()">
                        <option value="default">Selecione um nível</option>
                    </select>
                </div>
                <!-- filtro 2 seleciona a subcategoria -->
                <input type="hidden" id="valor_pesquisar" value="<?php echo htmlspecialchars($valor_pesquisar); ?>">
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
                <!-- Campo de pesquisa que você escreve o nome do curso-->
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
        <!-- Onde vai aparecer todos os cursos -->
        <div class="retangulocursos">
            <?php
                //pesquisa no banco de dados todos os cursos do mesmo departamento do cliente
                $query_cursos_recentes = "SELECT * FROM curso WHERE Categoria = '$id_categoria_atual'";
                
                // Adicionando a condição de pesquisa por nome, se houver
                if (!empty($valor_pesquisar)) {
                    $query_cursos_recentes .= " AND Nome LIKE '%$valor_pesquisar%'";
                }

                // Adicionando a condição de subcategoria, se houver
                if ($subcategoria && $subcategoria !== 'default') {
                    $query_cursos_recentes .= " AND Subcategoria = '$subcategoria'";
                }

                // Ordena os resultados por data de criação
                $query_cursos_recentes .= " ORDER BY Datadecriacao DESC";

                // pega e carrega as informações do banco de dados
                $result_cursos_recentes = mysqli_query($conn, $query_cursos_recentes);

                //verifica se retornou algo
                if ($result_cursos_recentes) {
                    while ($row = mysqli_fetch_assoc($result_cursos_recentes)) {
                        //banner com os cursos que aparecem na página
                        echo "<div class='bannersprofissoes_dois'>";
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
                // se não tiver nada salvo na variavel dá erro
                } else {
                    echo "Erro na execução da consulta: " . mysqli_error($conn);
                }
            ?>
        </div>
        <!-- Rodapé da página-->
        <?php require "rodape.php"; ?>
        <!-- Javascript -->
        <script src="js/darkmode.js"></script>
        <script src="js/zoom.js"></script>
        <script src="js/filtro2.js"></script>
    </body>
</html>