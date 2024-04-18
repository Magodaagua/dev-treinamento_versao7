<!doctype html>
<html lang="pt-br">
    <!-- Conexão com o banco de dados -->
	<?php
        include_once("php/conexao.php");

        $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
            $row_usuario['ID_usuario']."<br>";		
            $row_usuario['Senha']."<br>"; 

        $id_user = $row_usuario['ID_usuario'];
        $dep = $row_usuario['Dep'];
        $nome_usuario = $row_usuario['Nome'];
        //Verificar se está sendo passado na URL a página atual, senao é atribuido a pagina 

        //Selecionar os cursos a serem apresentado na página
        $result_inscricao = "SELECT * FROM inscricao WHERE id_usuario = '$id_user'";
        $resultado_inscricao = mysqli_query($conn, $result_inscricao);
        $total_inscricao = mysqli_num_rows($resultado_inscricao);

        $result_cursos2 = "  SELECT c.ID_curso, c.Nome, c.Categoria, c.Subcategoria, c.Descricao, c.Datadecriacao, c.Carga_horaria, c.inscritos, c.imagem
                            FROM curso c
                            INNER JOIN inscricao i ON c.ID_curso = i.id_curso
                            WHERE i.id_usuario = '$id_user'";

        $resultado_cursos2 = mysqli_query($conn, $result_cursos2);
        $total_cursos2 = mysqli_num_rows($resultado_cursos2);

        // Contar o total de cursos na categoria
        $result_contagem = "SELECT COUNT(*) AS total FROM inscricao WHERE id_usuario = '$id_user'";
        $contagem_resultado = mysqli_query($conn, $result_contagem);
        $contagem = mysqli_fetch_assoc($contagem_resultado);
        $total_meus_cursos = $contagem['total'];

	?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">

        <title>Portal de Cursos - Biblioteca</title>
        <!--coloca o icone na aba da tela-->
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
                <br><br><BR><BR><br><br><br>
                    <h1> <center>Minhas Inscrições </center>
                </h1><br>
                <div class="container theme-showcase">
                    &nbsp;&nbsp;&nbsp;<h6 class="totalcursos">&nbsp;&nbsp;Total inscritos: <?php echo $total_meus_cursos;?></h6>
                    <div class="album py-5 bg-light">
                        <div class="container">
                            <div class="row">
                                <?php while($rows_cursos = mysqli_fetch_assoc($resultado_cursos2)) { ?>
                                <div class="col-md-4">
                                    <div class="card mb-4 shadow-sm">
                                        <!-- Seu código HTML para exibir os cursos aqui -->
                                        <div class="linha2">
                                            <div class="esquerda"><img src="../COMUM/img/cursos/capa_dos_cursos/<?php echo $rows_cursos['imagem'];?>"></div>
                                            <div class="direita"><?php echo $rows_cursos['Nome']; ?></p></div>
                                        </div>
                                        <div class="card-body">
                                            <?php 
                                                $Testesubcategoria = $rows_cursos['Subcategoria'];
                                                $pegar = "SELECT Nome FROM subcategoria WHERE id = $Testesubcategoria";
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
                                                    // Exibir botões para todos os cursos
                                                    if ($testador == 100){
                                                        echo "<a href='detalhes.php?ID_curso={$rows_cursos['ID_curso']}&progresso=0'><button type='button' class='btn btn-sm btn-outline-success'>Finalizado</button></a>";
                                                    } elseif ($testador >= 0 && $testador <= 100) {
                                                        echo "<a href='detalhes.php?ID_curso={$rows_cursos['ID_curso']}&progresso=0'><button type='button' class='btn btn-sm btn-outline-primary'>Continuar</button></a>";
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
        </div>
        <!--inicio Botão de voltar ao topo-->
        <button id="myBtn" title="Go to top">Subir</button>
        <script>window.jQuery || document.write('<script src="javascript/jquery.slim.min.js"><\/script>')</script><script src="javascript/bootstrap.bundle.min.js"></script>  
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="javascript/subir.js"></script> 
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script src="javascript/darkmode.js"></script>
    </body>
</html>