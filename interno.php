<!doctype html>
<html lang="pt-br">
    <!-- Conexão com o banco de dados -->
	<?php
        include_once("php/conexao.php");
        $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
            $row_usuario['ID_usuario']."<br>";		
            $row_usuario['senha']."<br>";
            $dep = $row_usuario['Dep'];
            $nome_usuario = $row_usuario['Nome'];

        //Selecionar todos os cursos da tabela
        $result_categoria = "SELECT * FROM categoria";
        $resultado_categoria = mysqli_query($conn, $result_categoria);

        //Verificar se está sendo passado na URL a página atual, senao é atribuido a pagina 
        $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

        $categoria = $_GET['Nome_cat'];

        //$categoria = $conn->real_escape_string($_GET['Nome_cat']); // Sanitize the input

        // Contar o total de cursos na categoria
        $result_contagem = "SELECT COUNT(*) AS total FROM categoria WHERE Nome_cat = '$categoria'";
        $contagem_resultado = mysqli_query($conn, $result_contagem);
        $contagem = mysqli_fetch_assoc($contagem_resultado);
        $total_cursos = $contagem['total'];

        //Contar o total de cursos
        //$total_cursos = mysqli_num_rows($resultado_categoria);

        //Seta a quantidade de cursos por pagina
        $quantidade_pg = 9;

        //calcular o número de pagina necessárias para apresentar os cursos
        $num_pagina = ceil($total_cursos/$quantidade_pg);

        //Calcular o inicio da visualizacao
        $inicio = ($quantidade_pg*$pagina)-$quantidade_pg;

        //Selecionar os cursos a serem apresentado na página
        $result_categoria = "SELECT * FROM categoria WHERE Nome_cat = '$categoria' OR tipo = 'Pública' limit $inicio, $quantidade_pg";
        $resultado_categoria = mysqli_query($conn, $result_categoria);
        $total_cursos = mysqli_num_rows($resultado_categoria);

	?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>Site de Treinamento - interno</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!--coloca o icone na aba da tela-->
        <link rel="icon" type="png" href="../COMUM/img/Icons/Vermelho/copi.png">

        <style>
            .col-md-4{
                justify-content: center;
                text-align: center;
                margin-bottom: 20px;
                /*border: 1px solid #000;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0px 4px 12px grey;*/
            }

            .shadow-sm{
                border-radius: 8px;
                box-shadow: 4px 4px 12px grey;

                box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
                -moz-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
                -webkit-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
                -o-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
                -ms-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
            }

            #button1{
                justify-content: center;
                align-items: center;
            }

            .page-item.active {
                background-color: #007bff; /* Cor azul de destaque */
                color: #fff; /* Cor do texto em destaque */
            }

            .principal{
                width:100%;
                height: auto;
            }

        </style>
        
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!--CSS -->
        <link rel="stylesheet" type="text/css" href="css/titulo.css">
    </head>
    <body>
        <?php require "titulo.php"; ?>
            <?php }?> 
            <main class="principal">
                <br><br>
                <h1 class="titulo"> <center>Treinamento Interno </center></h1>
                <br><br>
                <div class="album py-5 bg-light">
                    <div class="container">
                        <!-- Three columns of text below the carousel -->
                        <div class="row">
                            <?php while($rows_categoria = mysqli_fetch_assoc($resultado_categoria)){?>
                            <div class="col-md-4">
                                <div class="card mb-4 shadow-sm">
                                    <!--<div class="card mb-4 shadow-sm">-->
                                    <br>
                                    <center>
                                        <img src="admin/logo/<?php echo $rows_categoria['id'];?>/<?php echo $rows_categoria['imagem'];?>" class="bd-placeholder-img rounded-square" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#55595c"/>
                                    </center>
                                    <!--<div class="d-flex justify-content-between align-items-center">-->
                                    <div class="card-body">    
                                        <h2><?php echo $rows_categoria['Nome_cat'];?></h2>
                                        <br>
                                        <center><a class="btn btn-primary" id="button1" href="curso.php?Nome_cat=<?php echo $rows_categoria['Nome_cat'];?>" target="_blank">Acesse aqui &raquo;</a></center>
                                    </div>
                                </div><!-- /.card mb-4 shadow-sm -->
                            </div><!-- /.col-md-4 -->
                                <!-- Modal -->
                                <div class="modal fade" id="privacydetalhes_<?php echo $rows_categoria['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Detalhes do Parceiro</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div> 
                                        <div class="modal-body">
                                            <?php echo $rows_categoria['id'];?>
                                        </div>
                                        </div>
                                    </div>
                                </div> 
                                <!--fim modal-->
                            <?php }?>    
                        </div><!-- /.row -->
                    </div>
                        <?php
                                    //Verificar a pagina anterior e posterior
                                    $pagina_anterior = $pagina - 1;
                                    $pagina_posterior = $pagina + 1;
                                ?>
                                <nav aria-label="...">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item">
                                            <?php
                                            if($pagina_anterior != 0){ ?>
                                                <a class="page-link" href="interno.php?pagina=<?php echo $pagina_anterior; ?>&Nome_cat=<?php echo $categoria;?>" aria-label="Previous">
                                                    <!--<span aria-hidden="true">&laquo;</span>--> Previous
                                                </a>
                                            <?php }else{ ?>
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="interno.php?pagina=<?php echo $pagina_posterior; ?>&Nome_cat=<?php echo $categoria;?>" aria-label="Next">
                                                        <!--<span aria-hidden="true">&raquo;</span>--> Previous
                                                    </a>
                                                </li>
                                        <?php }  ?>
                                        </li>
                                        <?php for ($i = 1; $i <= $num_pagina; $i++) : ?>
                                        <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                                            <a class="page-link" href="interno.php?pagina=<?php echo $i; ?>&Nome_cat=<?php echo $categoria;?>"><?php echo $i; ?></a>
                                        </li>
                                        <?php endfor; ?>

                                        <?php //} ?>
                                        <li class="page-item">
                                            <?php
                                            if($pagina_posterior <= $num_pagina){ ?>
                                                <a class="page-link" href="interno.php?pagina=<?php echo $pagina_posterior; ?>&Nome_cat=<?php echo $categoria;?>" aria-label="Next">
                                                    <!--<span aria-hidden="true">&raquo;</span>--> Next
                                                </a>
                                            <?php }else{ ?>
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="interno.php?pagina=<?php echo $pagina_posterior; ?>&Nome_cat=<?php echo $categoria;?>" aria-label="Next">
                                                        <!--<span aria-hidden="true">&raquo;</span>--> Next
                                                    </a>
                                                </li>
                                        <?php }  ?>
                                        </li>
                                    </ul>
                                </nav>
                    </div>
                </div>
                <!--inicio Botão de voltar ao topo-->
                <button id="myBtn" title="Go to top">Subir</button>
            </main>
        <script src="javascript/subir.js"></script>
        <script src="javascript/darkmode.js"></script>
    </body>
</html>