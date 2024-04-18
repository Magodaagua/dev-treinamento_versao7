<!doctype html>
<html lang="pt-br">
    <!-- Conexão com o banco de dados -->
	<?php
        include_once("php/conexao.php"); 

        $categoria = isset($_GET['Nome_cat']) ? $_GET['Nome_cat'] : null;
        $subcategoria = isset($_GET['subcategoria']) ? $_GET['subcategoria'] : null;

        $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
            $row_usuario['ID_usuario']."<br>";		
            $row_usuario['Senha']."<br>";

        $id_user = $row_usuario['ID_usuario'];
        $dep = $row_usuario['Dep'];
        $nome_usuario = $row_usuario['Nome'];

        //Selecionar todos os cursos da tabela
        $result_curso = "SELECT * FROM curso WHERE Categoria = '$categoria' AND Subcategoria = '$subcategoria'";
        $resultado_curso = mysqli_query($conn, $result_curso);

        //Selecionar todos os cursos que o usuário está inscrito
        $result_inscricao = "SELECT * FROM inscricao WHERE id_usuario = '$id_user'";
        $resultado_inscricao = mysqli_query($conn, $result_inscricao);

        $result_categoria1 = "SELECT * FROM categoria WHERE Nome_cat = '$categoria'";
        $resultado_categoria1 = mysqli_query($conn, $result_categoria1);

        if ($resultado_categoria1) {
            $row_categoria1 = mysqli_fetch_assoc($resultado_categoria1);
            $id_categoria_atual = $row_categoria1['id'];
            //var_dump($id_categoria_atual);
            // Agora $id_categoria_atual contém o ID da categoria atual
        } else {
            // Trate o erro, se houver algum
            echo "Erro na consulta: " . mysqli_error($conn);
        }

        // Contar o total de cursos na categoria
        $result_contagem = "SELECT COUNT(*) AS total FROM categoria WHERE Nome_cat = '$categoria'";
        $contagem_resultado = mysqli_query($conn, $result_contagem);
        $contagem = mysqli_fetch_assoc($contagem_resultado);
        $total_cursos = $contagem['total'];

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


        //Selecionar os cursos a serem apresentado na página
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
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">

        <title>Site de Treinamento - <?php echo $categoria ?></title>
        <link rel="icon" type="png" href="../COMUM/img/Icons/Vermelho/copi.png">
        <!--CSS -->
        <link rel="stylesheet" type="text/css" href="css/titulo.css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/curso.css" rel="stylesheet">
    </head>
    <body>
        <?php require "titulo.php"; ?>
            <?php }?> 
            <main>
                <br><br><br><br><br><br><br>
                <center>
                    <h1>
                        Cursos
                    </h1>
                </center><br>
                <div class="container theme-showcase">
                    <div class="page-header">
                        <div class="row">
                            <div class="linha">
                                <form class="form-inline" method="GET" action="pesquisar.php">
                                    <div class="form-group">&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label for="exampleInputName2">Pesquisar por Nome:&nbsp;&nbsp;</label>
                                        <input type="text" name="pesquisar" class="form-control" id="exampleInputName2" placeholder="Digitar...">
                                        <input type="hidden" name="categoria" id="categoria">
                                    </div>
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary" onclick="preencherCategoria()">Pesquisar</button>
                                </form>&nbsp;&nbsp;&nbsp;&nbsp;
                                <script>
                                    function preencherCategoria() {
                                        // Obtemos o valor da categoria (exemplo: "algum_valor")
                                        const categoria = "<?php echo $categoria ?>";  // Substitua pelo valor desejado ou crie a lógica para obtê-lo

                                        // Preenchemos o campo categoria com o valor obtido
                                        document.getElementById('categoria').value = categoria;
                                    }
                                </script>
                                <!-- PHP para definir a variável categoria -->
                                <?php
                                    echo '<script>';
                                    echo 'const categoria = "' . $categoria . '";';
                                    echo '</script>';
                                ?>
                                <label for="Categoria" class="col-form-label">Filtro por Categoria:</label>&nbsp;&nbsp;
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
                                </select>&nbsp;&nbsp;
                                <button id="LimparFiltro" class="btn btn-primary" onclick="limparFiltro()">Limpar</button>
                                <br><br>
                            </div>
                        </div>
                    </div><br>
                    <h6 class="totalcursos">&nbsp;&nbsp;Total de cursos: <?php echo $total_de_cursos;?></h6>
                    <div class="album py-5 bg-light">
                        <div class="container">
                            <div class="row">
                                <?php while($rows_cursos = mysqli_fetch_assoc($resultado_cursos)) { ?>
                                <div class="col-md-4">
                                    <div class="card mb-4 shadow-sm">
                                        <div class="linha2">
                                            <div class="esquerda"><img src="../COMUM/img/cursos/capa_dos_cursos/<?php echo $rows_cursos['imagem'];?>"></div>
                                            <div class="direita"><?php echo $rows_cursos['Nome']; ?></p></div>
                                        </div>
                                        <div class="card-body">
                                            <?php 
                                                $Testesubcategoria = $rows_cursos['Subcategoria'];
                                                $pegar = "SELECT Nome FROM subcategoria WHERE id = $Testesubcategoria and ID_categoria = $id_categoria_atual";
                                                $resultado_pegar = mysqli_query($conn, $pegar);
                                                if($resultado_pegar){
                                                    $dados_subcategoria = mysqli_fetch_assoc($resultado_pegar);
                                                    $nome_subcategoria = $dados_subcategoria['Nome'];

                                                    // Agora você pode usar $nome_subcategoria conforme necessário
                                                } else {
                                                    // Trate o erro, se houver algum
                                                    echo "Erro na consulta: " . mysqli_error($conn);
                                                }
                                            ?>
                                            <p class="card-text">Categoria: <?php echo $nome_subcategoria?></p>
                                            <div class="linha">
                                                <div class="texto-esquerda"><img src="../COMUM/img/Icons/Preto/pessoas.png"> Inscritos: <?php echo $rows_cursos['inscritos'];?></div>
                                                <div class="texto-direita"><img src="../COMUM/img/Icons/cinzaEscuro/clock.png">Carga Horária: <?php echo $rows_cursos['Carga_horaria'];?>h</div>
                                            </div><br>
                                            <p class="descricaotext"><?php echo mb_substr($rows_cursos['Descricao'], 0, 33, 'utf-8'); ?>...</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                            <?php 
                                                // Defina uma flag para verificar se o usuário está inscrito
                                                $usuarioInscrito = false;

                                                // Reinicie o ponteiro do resultado
                                                mysqli_data_seek($resultado_inscricao, 0);
                                                
                                                while($rows_inscricao = mysqli_fetch_assoc($resultado_inscricao)) {
                                                    $testador = $rows_inscricao['progresso'];

                                                    if ($rows_cursos['ID_curso'] == $rows_inscricao['id_curso']) {
                                                        $usuarioInscrito = true;

                                                        if ($testador == 100) {
                                                            echo "<div class='inscricaostatus'>Status: <font color= green> Concluído </font></div>";
                                                        } elseif ($testador >= 0 && $testador <= 100) {
                                                            echo "<div class='inscricaostatus'>Status: <font color=#0070ff> Em andamento</font></div>";
                                                        } else {
                                                            echo "<div class='inscricaostatus'>Status: <font color=red>Ainda não inscrito</font></div>";
                                                        }

                                                        // Exibimos o status apenas uma vez, então saímos do loop
                                                        break;
                                                    }
                                                }

                                                // Se o usuário não estiver inscrito, exiba a mensagem correspondente
                                                if (!$usuarioInscrito) {
                                                    echo "<div class='inscricaostatus'>Status: <font color=red> Ainda não inscrito</font></div>";
                                                }
                                            ?>
                                            </div><br>
                                            <div class="botaocurso">
                                                <?php 
                                                    // Verificar se o usuário está inscrito
                                                    if ($usuarioInscrito) {
                                                        // Se estiver inscrito, exibir o botão de "Continuar"
                                                        if ($testador == 100) {
                                                            echo "<a href='detalhes.php?ID_curso={$rows_cursos['ID_curso']}&progresso=0'><button type='button' class='btn btn-sm btn-outline-success'>Finalizado</button></a>";
                                                        } elseif ($testador >= 0 && $testador <= 100) {
                                                            echo "<a href='detalhes.php?ID_curso={$rows_cursos['ID_curso']}&progresso=0'><button type='button' class='btn btn-sm btn-outline-primary'>Continuar</button></a>";
                                                        }
                                                    } else {
                                                        // Se não estiver inscrito, exibir o botão de "Inscrever"
                                                        echo "<a href='detalhes.php?ID_curso={$rows_cursos['ID_curso']}&progresso=2'><button type='button' class='btn btn-sm btn-outline-danger'>Inscrever-se</button></a>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>   
                </div>
            </main>
        <!--inicio Botão de voltar ao topo-->
        <button id="myBtn" title="Go to top">Subir</button>
        <!--<script>window.jQuery || document.write('<script src="javascript/jquery.slim.min.js"><\/script>')</script><script src="javascript/bootstrap.bundle.min.js"></script>-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="javascript/subir.js"></script>     
        <script src="javascript/filtro.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>  
        <script src="javascript/darkmode.js"></script>                       
    </body>
</html>